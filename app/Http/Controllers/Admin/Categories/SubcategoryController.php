<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\Categories\SubcategoryService;

class SubcategoryController extends Controller
{
    public function __construct(private readonly SubcategoryService $service) {}

    /**
     * عرض التصنيفات الفرعية لتصنيف رئيسي معيّن
     */
    public function index(Request $request)
    {
        $categoryId = $request->category_id;

        $category = Category::findOrFail($categoryId);

        $subcategories = Subcategory::where('category_id', $categoryId)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.categories.sub.index', [
            'subcategories' => $subcategories,
            'category' => $category,
            'categoryId' => $categoryId
        ]);
    }

    /**
     * صفحة إنشاء تصنيف فرعي
     */
    public function create(Request $request)
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return view('admin.categories.sub.create', [
            'categories' => $categories,
            'category_id' => $request->category_id
        ]);
    }

    /**
     * حفظ تصنيف فرعي جديد
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'nullable'
        ]);

        $this->service->store($data);

        return redirect()
            ->route('admin.categories.sub.index', ['category_id' => $data['category_id']])
            ->with('success', __('subcategories.created_successfully'));
    }

    /**
     * صفحة تعديل تصنيف فرعي
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return view('admin.categories.sub.edit', [
            'subcategory' => $subcategory,
            'categories' => $categories
        ]);
    }

    /**
     * تحديث تصنيف فرعي
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $data = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'nullable'
        ]);

        $this->service->update($subcategory, $data);

        return redirect()
            ->route('admin.categories.sub.index', ['category_id' => $data['category_id']])
            ->with('success', __('subcategories.updated_successfully'));
    }

    /**
     * تعطيل تصنيف فرعي
     */
    public function disable(Subcategory $subcategory)
    {
        $subcategory->update(['is_active' => 0]);

        return redirect()
            ->back()
            ->with('success', 'تم إيقاف تفعيل التصنيف الفرعي');
    }

    /**
     * تفعيل تصنيف فرعي
     */
    public function enable(Subcategory $subcategory)
    {
        $subcategory->update(['is_active' => 1]);

        return redirect()
            ->back()
            ->with('success', 'تم تفعيل التصنيف الفرعي');
    }

    /**
     * حذف تصنيف فرعي
     */
    public function destroy(Subcategory $subcategory)
    {
        $categoryId = $subcategory->category_id;

        $this->service->delete($subcategory);

        return redirect()
            ->route('admin.categories.sub.index', ['category_id' => $categoryId])
            ->with('success', __('subcategories.deleted_successfully'));
    }
}
