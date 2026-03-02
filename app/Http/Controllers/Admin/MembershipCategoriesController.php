<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MembershipCategoriesController extends Controller
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
                abort(403, 'You do not have permission to manage membership categories.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $categories = MembershipCategory::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.membership_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.membership_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        MembershipCategory::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . time(),
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.membership_categories.index')->with('success', 'Membership category created successfully.');
    }

    public function edit(MembershipCategory $membership_category)
    {
        $category = $membership_category;
        return view('admin.membership_categories.edit', compact('category'));
    }

    public function update(Request $request, MembershipCategory $membership_category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $membership_category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . $membership_category->id,
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.membership_categories.index')->with('success', 'Membership category updated successfully.');
    }

    public function destroy(MembershipCategory $membership_category)
    {
        $membership_category->delete();
        return redirect()->route('admin.membership_categories.index')->with('success', 'Membership category deleted successfully.');
    }
}
