<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ServiceSubCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            $action = $request->route()->getActionMethod();

            if ($isSuper) {
                return $next($request);
            }

            if (in_array($action, ['index', 'show', 'ajax'])) {
                if (!$u->hasPermission('view_service_sub_category')) {
                    abort(403, 'You do not have permission to view sub categories.');
                }
            }

            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_service_sub_category')) {
                    abort(403, 'You do not have permission to create sub categories.');
                }
            }

            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_service_sub_category')) {
                    abort(403, 'You do not have permission to edit sub categories.');
                }
            }

            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_service_sub_category')) {
                    abort(403, 'You do not have permission to delete sub categories.');
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax() || $request->has('draw')) {
            $subCategories = ServiceSubCategory::with('category')
                ->withCount('services')
                ->when($request->category_id, function ($query) use ($request) {
                    return $query->where('service_category_id', $request->category_id);
                })
                ->orderBy('sort_order')
                ->orderBy('name');

            return DataTables::of($subCategories)
                ->addColumn('checkbox', function ($subCategory) {
                    return '<input type="checkbox" class="delete-checkbox" value="' . $subCategory->id . '">';
                })
                ->addColumn('category', function ($subCategory) {
                    return $subCategory->category ? 
                        '<span class="badge bg-primary">' . $subCategory->category->name . '</span>' : 
                        '-';
                })
                ->addColumn('services_count', function ($subCategory) {
                    return $subCategory->services_count;
                })
                ->addColumn('status', function ($subCategory) {
                    return $subCategory->status 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($subCategory) {
                    return view('admin.service_sub_categories._action', compact('subCategory'))->render();
                })
                ->rawColumns(['checkbox', 'category', 'status', 'actions'])
                ->make(true);
        }

        $categories = ServiceCategory::active()->orderBy('name')->get();
        return view('admin.service_sub_categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = ServiceCategory::active()->orderBy('name')->get();
        return view('admin.service_sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['status'] = $request->has('status');

        ServiceSubCategory::create($data);

        session()->flash('success', 'Sub category created successfully.');

        return redirect()->route('admin.service_sub_categories.index');
    }

    public function show(ServiceSubCategory $service_sub_category)
    {
        $service_sub_category->load('category', 'services');
        return view('admin.service_sub_categories.show', compact('service_sub_category'));
    }

    public function edit(ServiceSubCategory $service_sub_category)
    {
        $categories = ServiceCategory::active()->orderBy('name')->get();
        return view('admin.service_sub_categories.edit', compact('service_sub_category', 'categories'));
    }

    public function update(Request $request, ServiceSubCategory $service_sub_category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['status'] = $request->has('status');

        $service_sub_category->update($data);

        session()->flash('success', 'Sub category updated successfully.');

        return redirect()->route('admin.service_sub_categories.index');
    }

    public function destroy(ServiceSubCategory $service_sub_category)
    {
        $service_sub_category->delete();

        session()->flash('success', 'Sub category deleted successfully.');

        return redirect()->route('admin.service_sub_categories.index');
    }

    public function ajax(Request $request)
    {
        $subCategories = ServiceSubCategory::active()
            ->when($request->category_id, function ($query) use ($request) {
                return $query->where('service_category_id', $request->category_id);
            })
            ->orderBy('name')
            ->get();

        return response()->json($subCategories);
    }
}
