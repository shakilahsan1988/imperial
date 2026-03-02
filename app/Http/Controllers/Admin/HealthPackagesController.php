<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthPackage;
use App\Models\HealthPackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HealthPackagesController extends Controller
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
                abort(403, 'You do not have permission to manage health packages.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $packages = HealthPackage::with('category')->orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.health_packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = HealthPackageCategory::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.health_packages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . time();
        $data['status'] = $request->boolean('status', true);
        $data['show_on_frontend'] = $request->boolean('show_on_frontend', true);
        $data['recommended'] = $request->boolean('recommended', false);
        $data['immediate_availability'] = $request->boolean('immediate_availability', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if (!File::isDirectory('uploads/health_packages')) {
                File::makeDirectory('uploads/health_packages', 0755, true);
            }
            $image = $request->file('image');
            $name = 'health_package_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/health_packages', $name);
            $data['image'] = 'uploads/health_packages/' . $name;
        }

        HealthPackage::create($data);

        return redirect()->route('admin.health_packages.index')->with('success', 'Health package created successfully.');
    }

    public function edit(HealthPackage $health_package)
    {
        $package = $health_package;
        $categories = HealthPackageCategory::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.health_packages.edit', compact('package', 'categories'));
    }

    public function update(Request $request, HealthPackage $health_package)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']) . '-' . $health_package->id;
        $data['status'] = $request->boolean('status', false);
        $data['show_on_frontend'] = $request->boolean('show_on_frontend', false);
        $data['recommended'] = $request->boolean('recommended', false);
        $data['immediate_availability'] = $request->boolean('immediate_availability', false);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if (!File::isDirectory('uploads/health_packages')) {
                File::makeDirectory('uploads/health_packages', 0755, true);
            }
            $image = $request->file('image');
            $name = 'health_package_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/health_packages', $name);
            $data['image'] = 'uploads/health_packages/' . $name;
        } else {
            $data['image'] = $request->input('existing_image');
        }

        $health_package->update($data);

        return redirect()->route('admin.health_packages.index')->with('success', 'Health package updated successfully.');
    }

    public function destroy(HealthPackage $health_package)
    {
        $health_package->delete();
        return redirect()->route('admin.health_packages.index')->with('success', 'Health package deleted successfully.');
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'health_package_category_id' => 'required|exists:health_package_categories,id',
            'page_name' => 'required|string|max:120',
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:120',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'discount_text' => 'nullable|string|max:120',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:120',
            'turnaround' => 'nullable|string|max:120',
            'fasting' => 'nullable|string|max:120',
            'inclusions' => 'nullable|string',
            'preparation_steps' => 'nullable|string',
            'faq_1_question' => 'nullable|string|max:255',
            'faq_1_answer' => 'nullable|string',
            'faq_2_question' => 'nullable|string|max:255',
            'faq_2_answer' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
    }
}
