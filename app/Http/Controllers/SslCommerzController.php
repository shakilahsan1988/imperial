<?php

namespace App\Http\Controllers;

use App\Models\DoctorConsultationBooking;
use App\Models\SslCommerzTransaction;
use App\Services\SslCommerzService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SslCommerzController extends Controller
{
    protected SslCommerzService $sslCommerz;

    public function __construct(SslCommerzService $sslCommerz)
    {
        $this->sslCommerz = $sslCommerz;
    }

    /**
     * Handle successful payment redirect from SSLCommerz
     */
    public function success(Request $request)
    {
        $valId = $request->query('val_id');
        $tranId = $request->query('tran_id');

        if (empty($valId) || empty($tranId)) {
            return redirect()->route('book-doctor')->with('error', 'Invalid payment response. Please try again.');
        }

        $bookingId = $request->query('value_a') ? (int) $request->query('value_a') : null;

        if (!$bookingId) {
            return redirect()->route('book-doctor')->with('error', 'Invalid booking reference.');
        }

        $booking = DoctorConsultationBooking::find($bookingId);

        if (!$booking) {
            return redirect()->route('book-doctor')->with('error', 'Booking not found.');
        }

        // Prevent duplicate payment confirmation
        if ($booking->payment_status === 'paid') {
            return redirect()->route('doctor-booking.success', $booking->id);
        }

        // Validate via SSLCommerz validation API
        $validation = $this->sslCommerz->validatePayment($valId);

        // Log the validation attempt
        SslCommerzTransaction::where('transaction_id', $tranId)
            ->update(['status' => 'validated']);

        if ($validation['success']) {
            DB::beginTransaction();

            try {
                // Re-check inside transaction to prevent race condition
                $booking->refresh();
                if ($booking->payment_status === 'paid') {
                    DB::rollBack();
                    return redirect()->route('doctor-booking.success', $booking->id);
                }

                $booking->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $validation['transaction_id'],
                    'bank_transaction_id' => $validation['bank_transaction_id'],
                    'validation_id' => $valId,
                    'paid_amount' => $booking->consultation_fee,
                    'payment_date' => now(),
                ]);

                // Update the log transaction
                SslCommerzTransaction::where('transaction_id', $tranId)->update([
                    'bank_transaction_id' => $validation['bank_transaction_id'],
                    'validation_id' => $valId,
                    'status' => 'success',
                    'card_type' => $validation['card_type'] ?? null,
                    'card_no' => $validation['card_no'] ?? null,
                    'bank_gateway' => $validation['bank_gateway'] ?? null,
                ]);

                DB::commit();

                Log::info('SSLCommerz Payment Success', [
                    'booking_id' => $booking->id,
                    'tran_id' => $tranId,
                    'val_id' => $valId,
                ]);

                return redirect()->route('doctor-booking.success', $booking->id);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('SSLCommerz Success Handler Error', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);

                return redirect()->route('book-doctor')->with('error', 'Payment processed but there was an error updating your booking. Please contact support.');
            }
        }

        // Validation failed
        SslCommerzTransaction::where('transaction_id', $tranId)->update([
            'status' => 'failed',
        ]);

        Log::warning('SSLCommerz Payment Validation Failed', [
            'booking_id' => $booking->id,
            'tran_id' => $tranId,
            'val_id' => $valId,
        ]);

        return redirect()->route('doctor-booking.fail', $booking->id)
            ->with('error', 'Payment verification failed. Please try again or contact support.');
    }

    /**
     * Handle failed payment redirect from SSLCommerz
     */
    public function fail(Request $request)
    {
        $tranId = $request->query('tran_id');
        $bookingId = $request->query('value_a') ? (int) $request->query('value_a') : null;

        if ($bookingId) {
            $booking = DoctorConsultationBooking::find($bookingId);
            if ($booking && $booking->payment_status !== 'paid') {
                $booking->update(['payment_status' => 'failed']);
            }

            if ($tranId) {
                SslCommerzTransaction::where('transaction_id', $tranId)->update([
                    'status' => 'failed',
                ]);
            }

            Log::info('SSLCommerz Payment Failed', [
                'booking_id' => $bookingId,
                'tran_id' => $tranId,
            ]);

            return redirect()->route('doctor-booking.fail', $bookingId);
        }

        return redirect()->route('book-doctor')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Handle payment cancellation from SSLCommerz
     */
    public function cancel(Request $request)
    {
        $tranId = $request->query('tran_id');
        $bookingId = $request->query('value_a') ? (int) $request->query('value_a') : null;

        if ($bookingId) {
            $booking = DoctorConsultationBooking::find($bookingId);
            if ($booking && $booking->payment_status !== 'paid') {
                $booking->update(['payment_status' => 'cancelled']);
            }

            if ($tranId) {
                SslCommerzTransaction::where('transaction_id', $tranId)->update([
                    'status' => 'cancelled',
                ]);
            }

            Log::info('SSLCommerz Payment Cancelled', [
                'booking_id' => $bookingId,
                'tran_id' => $tranId,
            ]);

            return redirect()->route('doctor-booking.confirm', $bookingId)
                ->with('error', 'Payment was cancelled. You can try paying again or choose cash payment.');
        }

        return redirect()->route('doctor')
            ->with('error', 'Payment was cancelled.');
    }

    /**
     * Handle Instant Payment Notification (IPN) from SSLCommerz server
     */
    public function ipn(Request $request)
    {
        $valId = $request->input('val_id');
        $tranId = $request->input('tran_id');

        Log::info('SSLCommerz IPN Received', [
            'val_id' => $valId,
            'tran_id' => $tranId,
            'all_params' => $request->all(),
        ]);

        if (empty($valId) || empty($tranId)) {
            return response('INVALID', 400);
        }

        // Validate via SSLCommerz validation API
        $validation = $this->sslCommerz->validatePayment($valId);

        // Store raw IPN response
        $logTransaction = SslCommerzTransaction::where('transaction_id', $tranId)->first();
        if ($logTransaction) {
            $logTransaction->update([
                'ipn_response' => $request->all(),
                'status' => $validation['success'] ? 'validated' : 'failed',
                'validation_id' => $valId,
            ]);
        }

        if ($validation['success']) {
            $bookingId = $request->input('value_a') ? (int) $request->input('value_a') : null;

            if (!$bookingId) {
                return response('INVALID', 400);
            }

            DB::beginTransaction();

            try {
                $booking = DoctorConsultationBooking::lockForUpdate()->find($bookingId);

                if (!$booking) {
                    DB::rollBack();
                    return response('INVALID', 400);
                }

                // Prevent duplicate confirmation
                if ($booking->payment_status === 'paid') {
                    DB::rollBack();
                    return response('OK', 200);
                }

                $booking->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $validation['transaction_id'],
                    'bank_transaction_id' => $validation['bank_transaction_id'],
                    'validation_id' => $valId,
                    'paid_amount' => $booking->consultation_fee,
                    'payment_date' => now(),
                ]);

                if ($logTransaction) {
                    $logTransaction->update([
                        'bank_transaction_id' => $validation['bank_transaction_id'],
                        'status' => 'success',
                        'card_type' => $validation['card_type'] ?? null,
                        'card_no' => $validation['card_no'] ?? null,
                        'bank_gateway' => $validation['bank_gateway'] ?? null,
                    ]);
                }

                DB::commit();

                Log::info('SSLCommerz IPN Processed Successfully', [
                    'booking_id' => $bookingId,
                    'tran_id' => $tranId,
                ]);

                return response('OK', 200);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('SSLCommerz IPN Processing Error', [
                    'booking_id' => $bookingId,
                    'error' => $e->getMessage(),
                ]);

                return response('ERROR', 500);
            }
        }

        Log::warning('SSLCommerz IPN Validation Failed', [
            'tran_id' => $tranId,
            'val_id' => $valId,
        ]);

        return response('INVALID', 400);
    }

    /**
     * Show doctor booking success page
     */
    public function doctorBookingSuccess($id)
    {
        $booking = DoctorConsultationBooking::with(['doctor.specialty', 'doctor.department', 'slot', 'branch'])
            ->where('payment_status', 'paid')
            ->findOrFail($id);

        return view('frontend.booking.doctor-booking-success', compact('booking'));
    }

    /**
     * Show doctor booking fail page
     */
    public function doctorBookingFail($id)
    {
        $booking = DoctorConsultationBooking::with(['doctor.specialty', 'doctor.department', 'slot', 'branch'])
            ->findOrFail($id);

        $doctorSlug = optional($booking->doctor)->slug ?? optional($booking->doctor)->id;

        return view('frontend.booking.doctor-booking-fail', compact('booking', 'doctorSlug'));
    }
}
