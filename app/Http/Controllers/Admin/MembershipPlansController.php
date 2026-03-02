<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MembershipPlansController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            if ($isSuper) {
                return $next($request);
            }

            if (!$u || !$u->hasPermission('view_setting')) {
                abort(403, 'You do not have permission to manage membership plans.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $plans = MembershipPlan::with('category')->orderBy('sort_order')->orderBy('name')->paginate(20);
        $module = 'membership';
        return view('admin.membership_plans.index', compact('plans', 'module'));
    }

    public function consultantIndex()
    {
        $plans = MembershipPlan::with('category')
            ->where('is_video_consultant', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);
        $module = 'video_consultant';
        return view('admin.membership_plans.index', compact('plans', 'module'));
    }

    public function create()
    {
        $categories = MembershipCategory::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $isVideoDefault = request()->boolean('video', false);
        $module = $isVideoDefault ? 'video_consultant' : 'membership';
        return view('admin.membership_plans.create', compact('categories', 'isVideoDefault', 'module'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['show_on_frontend'] = $request->boolean('show_on_frontend', true);
        $data['is_video_consultant'] = $request->boolean('is_video_consultant', false);
        $data['status'] = $request->boolean('status', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if (!File::isDirectory('uploads/membership_plans')) {
                File::makeDirectory('uploads/membership_plans', 0755, true);
            }
            $image = $request->file('image');
            $name = 'membership_plan_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/membership_plans', $name);
            $data['image'] = 'uploads/membership_plans/' . $name;
        }

        MembershipPlan::create($data);

        $redirectRoute = $data['is_video_consultant']
            ? 'admin.video_consultant_packages.index'
            : 'admin.membership_plans.index';

        return redirect()->route($redirectRoute)->with('success', 'Membership plan created successfully.');
    }

    public function edit(MembershipPlan $membership_plan)
    {
        $plan = $membership_plan;
        $categories = MembershipCategory::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        $module = $plan->is_video_consultant ? 'video_consultant' : 'membership';
        $isVideoDefault = $plan->is_video_consultant;
        return view('admin.membership_plans.edit', compact('plan', 'categories', 'module', 'isVideoDefault'));
    }

    public function update(Request $request, MembershipPlan $membership_plan)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . $membership_plan->id;
        $data['show_on_frontend'] = $request->boolean('show_on_frontend', false);
        $data['is_video_consultant'] = $request->boolean('is_video_consultant', false);
        $data['status'] = $request->boolean('status', false);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if (!File::isDirectory('uploads/membership_plans')) {
                File::makeDirectory('uploads/membership_plans', 0755, true);
            }
            $image = $request->file('image');
            $name = 'membership_plan_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/membership_plans', $name);
            $data['image'] = 'uploads/membership_plans/' . $name;
        } else {
            $data['image'] = $request->input('existing_image');
        }

        $membership_plan->update($data);

        $redirectRoute = $data['is_video_consultant']
            ? 'admin.video_consultant_packages.index'
            : 'admin.membership_plans.index';

        return redirect()->route($redirectRoute)->with('success', 'Membership plan updated successfully.');
    }

    public function destroy(MembershipPlan $membership_plan)
    {
        $membership_plan->delete();
        return redirect()->route('admin.membership_plans.index')->with('success', 'Membership plan deleted successfully.');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'membership_category_id' => 'required|exists:membership_categories,id',
            'page_name' => 'required|string|max:120',
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:120',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'discount_text' => 'nullable|string|max:120',
            'duration' => 'nullable|string|max:120',
            'doctor_visits' => 'nullable|string|max:120',
            'service_discount' => 'nullable|string|max:120',
            'description' => 'nullable|string',
            'key_features' => 'nullable|string',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'important_notes' => 'nullable|string',
            'faq_1_question' => 'nullable|string|max:255',
            'faq_1_answer' => 'nullable|string',
            'faq_2_question' => 'nullable|string|max:255',
            'faq_2_answer' => 'nullable|string',
            'faq_3_question' => 'nullable|string|max:255',
            'faq_3_answer' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
    }
}
