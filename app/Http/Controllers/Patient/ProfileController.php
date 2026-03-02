<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\HealthPackageBooking;
use App\Models\MembershipPlanBooking;
use App\Http\Requests\Patient\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $patient = Patient::findOrFail(auth()->guard('patient')->user()['id']);

        $healthSummary = HealthPackageBooking::query()
            ->where(function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
                if (!empty($patient->email)) {
                    $q->orWhere('email', $patient->email);
                }
            })
            ->selectRaw('COALESCE(SUM(total_amount),0) as total, COALESCE(SUM(paid_amount),0) as paid, COALESCE(SUM(due_amount),0) as due')
            ->first();

        $membershipSummary = MembershipPlanBooking::query()
            ->whereHas('plan', function ($q) {
                $q->where('is_video_consultant', false);
            })
            ->where(function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
                if (!empty($patient->email)) {
                    $q->orWhere('email', $patient->email);
                }
            })
            ->selectRaw('COALESCE(SUM(total_amount),0) as total, COALESCE(SUM(paid_amount),0) as paid, COALESCE(SUM(due_amount),0) as due')
            ->first();

        $videoSummary = MembershipPlanBooking::query()
            ->whereHas('plan', function ($q) {
                $q->where('is_video_consultant', true);
            })
            ->where(function ($q) use ($patient) {
                $q->where('patient_id', $patient->id);
                if (!empty($patient->email)) {
                    $q->orWhere('email', $patient->email);
                }
            })
            ->selectRaw('COALESCE(SUM(total_amount),0) as total, COALESCE(SUM(paid_amount),0) as paid, COALESCE(SUM(due_amount),0) as due')
            ->first();

        $financialSummary = [
            'health' => $healthSummary,
            'membership' => $membershipSummary,
            'video' => $videoSummary,
            'grand' => (object) [
                'total' => (float) $healthSummary->total + (float) $membershipSummary->total + (float) $videoSummary->total,
                'paid' => (float) $healthSummary->paid + (float) $membershipSummary->paid + (float) $videoSummary->paid,
                'due' => (float) $healthSummary->due + (float) $membershipSummary->due + (float) $videoSummary->due,
            ],
        ];

        return view('patient.profile.edit', compact('patient', 'financialSummary'));
    }

    public function update(ProfileRequest $request)
    {
        Patient::where('id',auth()->guard('patient')->user()['id'])
                ->update($request->except('_token'));
        
        session()->flash('success',__('Profile updated successfully'));

        return redirect()->back();
    }
}
