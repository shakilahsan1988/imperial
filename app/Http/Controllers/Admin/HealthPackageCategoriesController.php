<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthPackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HealthPackageCategoriesController extends Controller
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
                abort(403, 'You do not have permission to manage health package categories.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $categories = HealthPackageCategory::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.health_package_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.health_package_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['status'] = $request->boolean('status', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        HealthPackageCategory::create($data);

        return redirect()->route('admin.health_package_categories.index')->with('success', 'Package category created successfully.');
    }

    public function edit(HealthPackageCategory $health_package_category)
    {
        $category = $health_package_category;
        return view('admin.health_package_categories.edit', compact('category'));
    }

    public function update(Request $request, HealthPackageCategory $health_package_category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $data['status'] = $request->boolean('status', false);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['slug'] = Str::slug($data['name']) . '-' . $health_package_category->id;

        $health_package_category->update($data);

        return redirect()->route('admin.health_package_categories.index')->with('success', 'Package category updated successfully.');
    }

    public function destroy(HealthPackageCategory $health_package_category)
    {
        $health_package_category->delete();
        return redirect()->route('admin.health_package_categories.index')->with('success', 'Package category deleted successfully.');
    }
}
