<?php

namespace App\Http\Controllers\Admin\Fields;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\Fields\FieldService;
use App\Http\Requests\Admin\Fields\StoreFieldRequest;
use App\Http\Requests\Admin\Fields\UpdateFieldRequest;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    protected FieldService $service;

    public function __construct(FieldService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = [
            'binding'        => $request->binding,
            'category_id'    => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ];

        // 🔥 ترتيب تنازلي + Pagination
        $fields = $this->service
            ->list($filters)
            ->orderBy('id', 'desc')
            ->paginate(10);

        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.fields.index', compact('fields', 'categories', 'subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.fields.create', compact('categories', 'subcategories'));
    }

    public function store(StoreFieldRequest $request)
    {
        // الخدمة تتكفل بإنشاء الحقل وربط خياراته داخل transaction واحد
        $this->service->create($request->validated());

        return redirect()->route('admin.fields.index')
            ->with('success', __('fields.created_successfully'));
    }

    public function edit(Field $field)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.fields.edit', compact('field', 'categories', 'subcategories'));
    }

    public function update(UpdateFieldRequest $request, Field $field)
    {
        $this->service->update($field, $request->validated());

        return redirect()->route('admin.fields.index')
            ->with('success', __('fields.updated_successfully'));
    }

    public function destroy(Field $field)
    {
        $this->service->delete($field);

        return redirect()->route('admin.fields.index')
            ->with('success', __('fields.deleted_successfully'));
    }
}
