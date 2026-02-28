<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientOtp;
use App\Mail\PatientOtpMail;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
    * show patient login form (Step 1: Email Entry)
    */
    public function showLoginForm()
    {
        return view('auth.patient.login');
    }

    /**
    * Generate and send OTP
    */
    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $otp = rand(100000, 999999);

        try {
            // Delete any existing OTPs for this email
            PatientOtp::where('email', $email)->delete();

            // Store new OTP
            PatientOtp::create([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);

            // Send Email
            Mail::to($email)->send(new PatientOtpMail($otp));

            // Store email in session for verify step
            session(['login_email' => $email]);

            return redirect()->route('patient.auth.verify')->with('success', __('Verification code sent to your email.'));
        } catch (\Exception $e) {
            \Log::error('OTP Send Error: ' . $e->getMessage());
            return back()->with('error', __('Failed to send verification code. Please check your email configuration or try again later.'));
        }
    }

    /**
     * Show verification form (Step 2: OTP Entry)
     */
    public function showVerifyForm()
    {
        if (!session('login_email')) {
            return redirect()->route('patient.auth.login');
        }

        return view('auth.patient.verify');
    }

    /**
     * Verify OTP and Login
     */
    public function verify_submit(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = session('login_email');
        if (!$email) {
            return redirect()->route('patient.auth.login');
        }

        $otpRecord = PatientOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($otpRecord) {
            // OTP is valid, delete it
            $otpRecord->delete();

            // Find or Create Patient
            $patient = Patient::where('email', $email)->first();

            if (!$patient) {
                // Auto-registration for new user
                $patient = Patient::create([
                    'email' => $email,
                    'code' => patient_code(),
                    'name' => 'New Patient', // Default name, they can update in profile
                    'gender' => 'male', // Default
                    'dob' => Carbon::now()->subYears(20)->format('Y-m-d'), // Default
                ]);
                
                $is_new = true;
            } else {
                $is_new = false;
            }

            // Login
            Auth::guard('patient')->login($patient);
            session()->forget('login_email');

            if ($is_new || empty($patient->phone)) {
                return redirect()->route('patient.profile.edit')->with('success', __('Welcome! Please complete your profile information.'));
            }

            return redirect()->route('patient.index')->with('success', __('Login successful.'));
        }

        return back()->with('error', __('Invalid or expired verification code.'));
    }

    /**
    * logout patient
    */
    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        return redirect()->route('fhome');
    }
}
