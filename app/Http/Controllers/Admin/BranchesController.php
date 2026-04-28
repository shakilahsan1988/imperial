<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BranchesController extends Controller
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

            if (in_array($action, ['index', 'show', 'ajax']) && ! $u->hasPermission('view_branch')) {
                abort(403, 'You do not have permission to view branches.');
            }

            if (in_array($action, ['create', 'store']) && ! $u->hasPermission('create_branch')) {
                abort(403, 'You do not have permission to create branches.');
            }

            if (in_array($action, ['edit', 'update']) && ! $u->hasPermission('edit_branch')) {
                abort(403, 'You do not have permission to edit branches.');
            }

            if ($action === 'destroy' && ! $u->hasPermission('delete_branch')) {
                abort(403, 'You do not have permission to delete branches.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        return view('admin.branches.index');
    }

    public function ajax(Request $request)
    {
        $model = Branch::withCount('galleries')->select('branches.*');

        return DataTables::of($model)
            ->addColumn('feature_image', function ($branch) {
                if ($branch->feature_image) {
                    return '<img src="'.asset($branch->feature_image).'" class="img-thumbnail" style="max-height: 55px;">';
                }

                return '-';
            })
            ->addColumn('title', function ($branch) {
                return e($branch->title ?: $branch->name);
            })
            ->addColumn('gallery_count', function ($branch) {
                return (string) $branch->galleries_count;
            })
            ->addColumn('action', function ($branch) {
                return view('admin.branches._action', compact('branch'));
            })
            ->rawColumns(['feature_image', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(BranchRequest $request)
    {
        try {
            $data = $this->syncLegacyFields($request->validated());

            if ($request->hasFile('feature_image')) {
                $data['feature_image'] = $this->storeImage($request->file('feature_image'), 'uploads/branches', 'branch_feature');
            }

            $branch = Branch::create($data);
            $this->syncGallery($request, $branch);

            return redirect()->route('admin.branches.index')->with('success', __('Branch created successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to create branch: ').$e->getMessage());
        }
    }

    public function show($id)
    {
        $branch = Branch::with(['galleries', 'managementTeams', 'doctors'])->findOrFail($id);

        return view('admin.branches.show', compact('branch'));
    }

    public function edit($id)
    {
        $branch = Branch::with('galleries')->findOrFail($id);

        return view('admin.branches.edit', compact('branch'));
    }

    public function update(BranchRequest $request, $id)
    {
        try {
            $branch = Branch::with('galleries')->findOrFail($id);
            $data = $this->syncLegacyFields($request->validated());

            if ($request->hasFile('feature_image')) {
                if ($branch->feature_image && File::exists($branch->feature_image)) {
                    File::delete($branch->feature_image);
                }

                $data['feature_image'] = $this->storeImage($request->file('feature_image'), 'uploads/branches', 'branch_feature');
            }

            $branch->update($data);
            $this->syncGallery($request, $branch);

            return redirect()->route('admin.branches.index')->with('success', __('Branch updated successfully'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Failed to update branch: ').$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $branch = Branch::with('galleries')->findOrFail($id);

            if ($branch->feature_image && File::exists($branch->feature_image)) {
                File::delete($branch->feature_image);
            }

            foreach ($branch->galleries as $gallery) {
                if ($gallery->image && File::exists($gallery->image)) {
                    File::delete($gallery->image);
                }
            }

            $branch->delete();

            return redirect()->route('admin.branches.index')->with('success', __('Branch deleted successfully'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to delete branch: ').$e->getMessage());
        }
    }

    protected function syncLegacyFields(array $data): array
    {
        $data['name'] = $data['title'];
        $data['slug'] = Str::slug($data['title']);
        $data['phone'] = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($data['contact_information']))), 255, '');

        return $data;
    }

    protected function storeImage($image, string $directory, string $prefix): string
    {
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $imageName = $prefix.'_'.time().'_'.Str::random(5).'.'.$image->getClientOriginalExtension();
        $image->move($directory, $imageName);

        return $directory.'/'.$imageName;
    }

    protected function syncGallery(BranchRequest $request, Branch $branch): void
    {
        foreach ($request->input('existing_gallery_names', []) as $galleryId => $name) {
            $gallery = $branch->galleries->firstWhere('id', (int) $galleryId);
            if ($gallery) {
                $gallery->update(['name' => $name]);
            }
        }

        $deleteIds = collect($request->input('delete_gallery_ids', []))->map(fn ($id) => (int) $id)->all();
        if ($deleteIds) {
            $galleries = $branch->galleries()->whereIn('id', $deleteIds)->get();
            foreach ($galleries as $gallery) {
                if ($gallery->image && File::exists($gallery->image)) {
                    File::delete($gallery->image);
                }
                $gallery->delete();
            }
        }

        foreach ($request->file('gallery_images', []) as $image) {
            $branch->galleries()->create([
                'name' => pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME),
                'image' => $this->storeImage($image, 'uploads/branches/gallery', 'branch_gallery'),
            ]);
        }
    }
}
