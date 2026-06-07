<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Categories\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $service) {}

    // عرض التصنيفات مع الترتيب الصحيح
    public function index()
    {
        // ترتيب بسيط حسب ID بدل sort_order
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        // ❌ شيلنا الكود تبع sort_order نهائيًا
        $this->service->store($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('categories.created_successfully'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->service->update($category, $request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('categories.updated_successfully'));
    }

    // حذف التصنيفات ممنوع
    public function destroy(Category $category)
    {
        return redirect()
            ->route('admin.categories.index')
            ->with('error', __('categories.delete_not_allowed'));
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function fields(Category $category)
    {
        return response()->json([
            'fields' => $category->fields()
                ->where('is_active', 1)
                // ❌ شيلنا orderBy(sort_order)
                ->get()
        ]);
    }
}
