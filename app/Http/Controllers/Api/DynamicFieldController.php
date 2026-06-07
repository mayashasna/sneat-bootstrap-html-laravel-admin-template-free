<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class DynamicFieldController extends Controller
{
    public function byCategory(Request $request)
    {
        $request->validate([
            'category_id'    => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);

        // If subcategory_id exists → load fields for subcategory
        if ($request->subcategory_id) {
            $fields = Field::where('dynamic_fieldable_type', Subcategory::class)
                ->where('dynamic_fieldable_id', $request->subcategory_id)
                ->orderBy('sort_order')
                ->get();
        }
        // Otherwise → load fields for category
        else {
            $fields = Field::where('dynamic_fieldable_type', Category::class)
                ->where('dynamic_fieldable_id', $request->category_id)
                ->orderBy('sort_order')
                ->get();
        }

        return response()->json([
            'status' => true,
            'data'   => $fields,
        ]);
    }
}
