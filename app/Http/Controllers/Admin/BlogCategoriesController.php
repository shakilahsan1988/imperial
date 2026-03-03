<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoriesController extends Controller
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
                abort(403, 'You do not have permission to manage blog categories.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $categories = BlogCategory::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.blog_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog_categories.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        $data = $request->validated();

        BlogCategory::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . time(),
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.blog_categories.index')->with('success', 'Blog category created successfully.');
    }

    public function edit(BlogCategory $blog_category)
    {
        $category = $blog_category;
        return view('admin.blog_categories.edit', compact('category'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blog_category)
    {
        $data = $request->validated();

        $blog_category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . $blog_category->id,
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.blog_categories.index')->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blog_category)
    {
        $blog_category->delete();
        return redirect()->route('admin.blog_categories.index')->with('success', 'Blog category deleted successfully.');
    }
}
