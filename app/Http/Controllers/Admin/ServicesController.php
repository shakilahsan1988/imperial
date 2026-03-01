<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Yajra\DataTables\Facades\DataTables;

class ServicesController extends Controller
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
                if (!$u->hasPermission('view_service')) {
                    abort(403, 'You do not have permission to view services.');
                }
            }

            if (in_array($action, ['create', 'store'])) {
                if (!$u->hasPermission('create_service')) {
                    abort(403, 'You do not have permission to create services.');
                }
            }

            if (in_array($action, ['edit', 'update'])) {
                if (!$u->hasPermission('edit_service')) {
                    abort(403, 'You do not have permission to edit services.');
                }
            }

            if ($action == 'destroy') {
                if (!$u->hasPermission('delete_service')) {
                    abort(403, 'You do not have permission to delete services.');
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax() || $request->has('draw')) {
            $search = $request->input('search')['value'] ?? null;
            
            $services = Service::with(['serviceCategory', 'subCategory'])
                ->select('services.*')
                ->withCount('bookings')
                ->when($request->service_category_id, function ($query) use ($request) {
                    return $query->where('service_category_id', $request->service_category_id);
                })
                ->when($request->service_sub_category_id, function ($query) use ($request) {
                    return $query->where('service_sub_category_id', $request->service_sub_category_id);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                          ->orWhere('short_name', 'like', '%' . $search . '%');
                    });
                })
                ->orderBy('sort_order')
                ->orderBy('name');

            return DataTables::of($services)
                ->addColumn('checkbox', function ($service) {
                    return '<input type="checkbox" class="delete-checkbox" value="' . $service->id . '">';
                })
                ->addColumn('category', function ($service) {
                    if ($service->serviceCategory) {
                        $colors = [
                            'laboratory' => 'bg-blue',
                            'imaging' => 'bg-purple',
                            'procedure' => 'bg-green',
                        ];
                        $color = $colors[$service->serviceCategory->type] ?? 'bg-gray';
                        return '<span class="badge ' . $color . ' text-uppercase">' . $service->serviceCategory->name . '</span>';
                    }
                    
                    if (is_string($service->category)) {
                        $colors = [
                            'laboratory' => 'bg-blue',
                            'imaging' => 'bg-purple',
                            'procedure' => 'bg-green',
                        ];
                        $color = $colors[$service->category] ?? 'bg-gray';
                        return '<span class="badge ' . $color . ' text-uppercase">' . ucfirst($service->category) . '</span>';
                    }
                    return '-';
                })
                ->addColumn('sub_category', function ($service) {
                    if ($service->subCategory) {
                        return $service->subCategory->name;
                    }
                    return $service->sub_category ?: '-';
                })
                ->addColumn('price', function ($service) {
                    return get_currency() . ' ' . number_format($service->price, 2);
                })
                ->addColumn('home_visit', function ($service) {
                    if ($service->home_visit_available) {
                        $html = '<span class="badge bg-success">Yes</span>';
                        if ($service->home_visit_price) {
                            $html .= '<br><small class="text-muted">+' . get_currency() . ' ' . number_format($service->home_visit_price, 2) . '</small>';
                        }
                        return $html;
                    }
                    return '<span class="badge bg-secondary">No</span>';
                })
                ->addColumn('status', function ($service) {
                    return $service->status 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('actions', function ($service) {
                    return view('admin.services._action', compact('service'))->render();
                })
                ->rawColumns(['checkbox', 'category', 'home_visit', 'status', 'actions'])
                ->make(true);
        }

        $categories = \App\Models\ServiceCategory::active()->orderBy('name')->get();
        return view('admin.services.index', compact('categories'));
    }

    public function create()
    {
        $categories = \App\Models\ServiceCategory::active()->orderBy('name')->get();
        $subCategories = \App\Models\ServiceSubCategory::active()->orderBy('name')->get();
        return view('admin.services.create', compact('categories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'service_sub_category_id' => 'nullable|exists:service_sub_categories,id',
            'price' => 'required|numeric|min:0',
            'home_visit_price' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:255',
            'reference_range' => 'nullable|string',
        ]);

        $data = $request->all();
        
        // Derive legacy category enum from the selected category
        $category = \App\Models\ServiceCategory::find($request->service_category_id);
        $data['category'] = $category->type;
        
        $data['home_visit_available'] = $request->has('home_visit_available');
        $data['show_on_frontend'] = $request->has('show_on_frontend');
        $data['status'] = $request->has('status');

        $service = Service::create($data);

        // Handle components
        if ($request->has('components')) {
            foreach ($request->components as $compData) {
                if (!empty($compData['name'])) {
                    $service->components()->create($compData);
                }
            }
        }

        session()->flash('success', 'Service created successfully.');

        return redirect()->route('admin.services.index');
    }

    public function show(Service $service)
    {
        $service->load(['serviceCategory', 'subCategory']);
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $categories = \App\Models\ServiceCategory::active()->orderBy('name')->get();
        $subCategories = \App\Models\ServiceSubCategory::active()->orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'categories', 'subCategories'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'service_sub_category_id' => 'nullable|exists:service_sub_categories,id',
            'price' => 'required|numeric|min:0',
            'home_visit_price' => 'nullable|numeric|min:0',
            'unit' => 'nullable|string|max:255',
            'reference_range' => 'nullable|string',
        ]);

        $data = $request->all();
        
        // Derive legacy category enum from the selected category
        $category = \App\Models\ServiceCategory::find($request->service_category_id);
        $data['category'] = $category->type;
        
        $data['home_visit_available'] = $request->has('home_visit_available');
        $data['show_on_frontend'] = $request->has('show_on_frontend');
        $data['status'] = $request->has('status');

        $service->update($data);

        // Handle components
        if ($request->has('components')) {
            $keepIds = [];
            foreach ($request->components as $compData) {
                if (!empty($compData['name'])) {
                    if (!empty($compData['id'])) {
                        $comp = \App\Models\ServiceComponent::find($compData['id']);
                        if ($comp) {
                            $comp->update($compData);
                            $keepIds[] = $comp->id;
                        }
                    } else {
                        $newComp = $service->components()->create($compData);
                        $keepIds[] = $newComp->id;
                    }
                }
            }
            // Delete components that were removed from the UI
            $service->components()->whereNotIn('id', $keepIds)->delete();
        } else {
            // If no components sent, delete all existing components
            $service->components()->delete();
        }

        session()->flash('success', 'Service updated successfully.');

        return redirect()->route('admin.services.index');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        session()->flash('success', 'Service deleted successfully.');

        return redirect()->route('admin.services.index');
    }

    public function ajax(Request $request)
    {
        $query = Service::active();

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('home_visit') && $request->home_visit) {
            $query->where('home_visit_available', true);
        }

        $services = $query->orderBy('name')->get();

        return response()->json($services);
    }
}
