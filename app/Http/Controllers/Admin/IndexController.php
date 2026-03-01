<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Group;
use App\Models\GroupTest;
use App\Models\Visit;
use App\Models\Expense;
use App\Models\Contract;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            if ($u && ($u->id == 1 || auth()->guard('admin')->check())) {
                return $next($request);
            }
            abort(403, 'You do not have permission to view the dashboard.');
        });
    }

    public function index()
    {
        // Statistics
        $services_count = Service::count();
        $bookings_count = Booking::count();
        $patients_count = Patient::count();
        $contracts_count = Contract::count();
        $visits_count = Visit::count();
       
        // Report/Test statistics based on new system
        $group_tests_count = GroupTest::count();
        $pending_tests_count = GroupTest::where('done', false)->count();
        $done_tests_count = GroupTest::where('done', true)->count();

        // New home visits
        $visits = Visit::with('patient')->where('read', false)->get();

        // Today's scheduled visits
        $today_visits = Visit::with('patient')->whereDate('visit_date', now())->get();

        // Financials
        $today_paid = Group::whereDate('created_at', now())->sum('paid');
        $today_total_expense = Expense::whereDate('date', now())->sum('amount');
        $today_profit = $today_paid - $today_total_expense;
        
        return view('admin.index', compact(
            'services_count',
            'bookings_count',
            'patients_count',
            'group_tests_count',
            'pending_tests_count',
            'done_tests_count',
            'visits',
            'today_visits',
            'today_paid',
            'today_total_expense',
            'today_profit',
            'contracts_count',
            'visits_count'
        ));
    }
}
