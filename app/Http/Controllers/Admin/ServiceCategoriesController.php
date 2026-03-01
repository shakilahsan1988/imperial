<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ServiceCategoriesController extends Controller
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
                if (!$u->hasPermission('view_service_category')) {
                    abort(403, 'You do not have permission to view categories.');
                }
            }

            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_service_category')) {
                    abort(403, 'You do not have permission to create categories.');
                }
            }

            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_service_category')) {
                    abort(403, 'You do not have permission to edit categories.');
                }
            }

            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_service_category')) {
                    abort(403, 'You do not have permission to delete categories.');
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax() || $request->has('draw')) {
            $categories = ServiceCategory::withCount('services', 'subCategories')
                ->orderBy('sort_order')
                ->orderBy('name');

            return DataTables::of($categories)
                ->addColumn('checkbox', function ($category) {
                    return '<input type="checkbox" class="delete-checkbox" value="' . $category->id . '">';
                })
                ->addColumn('type', function ($category) {
                    $colors = [
                        'laboratory' => 'bg-blue',
                        'imaging' => 'bg-purple',
                        'procedure' => 'bg-green',
                    ];
                    $color = $colors[$category->type] ?? 'bg-gray';
                    return '<span class="badge ' . $color . ' text-uppercase">' . ucfirst($category->type) . '</span>';
                })
                ->addColumn('services_count', function ($category) {
                    return $category->services_count;
                })
                ->addColumn('sub_categories_count', function ($category) {
                    return $category->sub_categories_count;
                })
                ->addColumn('status', function ($category) {
                    return $category->status 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($category) {
                    return view('admin.service_categories._action', compact('category'))->render();
                })
                ->rawColumns(['checkbox', 'type', 'status', 'actions'])
                ->make(true);
        }

        return view('admin.service_categories.index');
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:laboratory,imaging,procedure',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['status'] = $request->has('status');

        ServiceCategory::create($data);

        session()->flash('success', 'Category created successfully.');

        return redirect()->route('admin.service_categories.index');
    }

    public function show(ServiceCategory $service_category)
    {
        $service_category->load('subCategories', 'services');
        return view('admin.service_categories.show', compact('service_category'));
    }

    public function edit(ServiceCategory $service_category)
    {
        return view('admin.service_categories.edit', compact('service_category'));
    }

    public function update(Request $request, ServiceCategory $service_category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:laboratory,imaging,procedure',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['status'] = $request->has('status');

        $service_category->update($data);

        session()->flash('success', 'Category updated successfully.');

        return redirect()->route('admin.service_categories.index');
    }

    public function destroy(ServiceCategory $service_category)
    {
        $service_category->delete();

        session()->flash('success', 'Category deleted successfully.');

        return redirect()->route('admin.service_categories.index');
    }
}
