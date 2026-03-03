<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogsController extends Controller
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
                abort(403, 'You do not have permission to manage blogs.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $blogs = Blog::with('category')->orderByDesc('published_at')->orderByDesc('created_at')->paginate(20);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();
        if (!File::isDirectory('uploads/blogs')) {
            File::makeDirectory('uploads/blogs', 0755, true);
        }

        if ($request->hasFile('featured_image_file')) {
            $image = $request->file('featured_image_file');
            $imageName = 'blog_' . time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/blogs', $imageName);
            $data['featured_image'] = 'uploads/blogs/' . $imageName;
        }

        $blog = Blog::create([
            'blog_category_id' => $data['blog_category_id'] ?? null,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . time(),
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'],
            'featured_image' => $data['featured_image'] ?? null,
            'author_name' => $data['author_name'] ?? null,
            'published_at' => $data['published_at'] ?? null,
            'status' => $request->boolean('status', true),
            'is_featured' => $request->boolean('is_featured', false),
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ]);

        $blog->update(['slug' => Str::slug($blog->title) . '-' . $blog->id]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();
        if (!File::isDirectory('uploads/blogs')) {
            File::makeDirectory('uploads/blogs', 0755, true);
        }

        if ($request->hasFile('featured_image_file')) {
            $image = $request->file('featured_image_file');
            $imageName = 'blog_' . time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/blogs', $imageName);
            $data['featured_image'] = 'uploads/blogs/' . $imageName;
        }

        $blog->update([
            'blog_category_id' => $data['blog_category_id'] ?? null,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . $blog->id,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'],
            'featured_image' => $data['featured_image'] ?? null,
            'author_name' => $data['author_name'] ?? null,
            'published_at' => $data['published_at'] ?? null,
            'status' => $request->boolean('status', false),
            'is_featured' => $request->boolean('is_featured', false),
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
