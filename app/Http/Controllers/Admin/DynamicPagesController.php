<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class DynamicPagesController extends Controller
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
                abort(403, 'You do not have permission to manage dynamic pages.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $pages = Page::orderBy('sort_order')->orderBy('title')->paginate(20);
        return view('admin.dynamic_pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.dynamic_pages.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['settings_json'] = $this->normalizeSettingsJson($request->input('settings_json'));
        $data['status'] = $request->boolean('status', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['layout_type'] = $data['layout_type'] ?? 'default';

        if (!File::isDirectory('uploads/pages/dynamic')) {
            File::makeDirectory('uploads/pages/dynamic', 0755, true);
        }

        if ($request->hasFile('hero_image_file')) {
            $image = $request->file('hero_image_file');
            $imageName = 'page_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/pages/dynamic', $imageName);
            $data['hero_image'] = 'uploads/pages/dynamic/' . $imageName;
        }

        Page::create($data);

        return redirect()->route('admin.dynamic_pages.index')->with('success', 'Dynamic page created successfully.');
    }

    public function edit(Page $dynamic_page)
    {
        $page = $dynamic_page;
        return view('admin.dynamic_pages.edit', compact('page'));
    }

    public function update(Request $request, Page $dynamic_page)
    {
        $data = $this->validateData($request, $dynamic_page->id);
        $data['settings_json'] = $this->normalizeSettingsJson($request->input('settings_json'));
        $data['status'] = $request->boolean('status', false);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['layout_type'] = $data['layout_type'] ?? 'default';

        if (!File::isDirectory('uploads/pages/dynamic')) {
            File::makeDirectory('uploads/pages/dynamic', 0755, true);
        }

        if ($request->hasFile('hero_image_file')) {
            $image = $request->file('hero_image_file');
            $imageName = 'page_' . time() . '_' . $dynamic_page->id . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/pages/dynamic', $imageName);
            $data['hero_image'] = 'uploads/pages/dynamic/' . $imageName;
        }

        $dynamic_page->update($data);

        return redirect()->route('admin.dynamic_pages.index')->with('success', 'Dynamic page updated successfully.');
    }

    public function destroy(Page $dynamic_page)
    {
        $dynamic_page->delete();
        return redirect()->route('admin.dynamic_pages.index')->with('success', 'Dynamic page deleted successfully.');
    }

    private function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('pages', 'slug')->ignore($id),
            ],
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'layout_type' => 'nullable|string|max:50',
            'hero_title_html' => 'nullable|string|max:3000',
            'hero_description' => 'nullable|string|max:5000',
            'hero_image' => 'nullable|string|max:255',
            'hero_image_file' => 'nullable|image|max:4096',
            'body_html' => 'nullable|string',
            'settings_json' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }

    private function normalizeSettingsJson(?string $json): ?array
    {
        $json = trim((string) $json);
        if ($json === '') {
            return null;
        }

        $decoded = json_decode($json, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }
}

