<?php

namespace App\Http\Controllers\Admin\Fields;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldOption;
use Illuminate\Http\Request;

class FieldOptionController extends Controller
{
    /**
     * Show options list for a field
     */
    public function index(Field $field)
    {
        $options = $field->options()->get();

        return view('admin.fields.options.index', compact('field', 'options'));
    }

    /**
     * Show create option form
     */
    public function create(Field $field)
    {
        return view('admin.fields.options.create', compact('field'));
    }

    /**
     * Show edit option form
     */
    public function edit(Field $field, FieldOption $option)
    {
        return view('admin.fields.options.edit', compact('field', 'option'));
    }

    /**
     * Store a new option for a field
     */
    public function store(Request $request, Field $field)
    {
        $request->validate([
            'value_ar'   => 'required|string|max:255',
            'value_en'   => 'required|string|max:255',
            'is_active'  => 'nullable|boolean',
        ]);

        $field->options()->create([
            'value_ar'   => $request->value_ar,
            'value_en'   => $request->value_en,
            'is_active'  => $request->is_active ?? 0,
        ]);

        return redirect()
            ->route('admin.fields.options.index', $field->id)
            ->with('success', 'Option added successfully');
    }

    /**
     * Update an existing option
     */
    public function update(Request $request, Field $field, FieldOption $option)
    {
        $request->validate([
            'value_ar'   => 'required|string|max:255',
            'value_en'   => 'required|string|max:255',
            'is_active'  => 'nullable|boolean',
        ]);

        $option->update([
            'value_ar'   => $request->value_ar,
            'value_en'   => $request->value_en,
            'is_active'  => $request->is_active ?? 0,
        ]);

        return redirect()
            ->route('admin.fields.options.index', $field->id)
            ->with('success', 'Option updated successfully');
    }

    /**
     * Delete an option
     */
    public function destroy(Field $field, FieldOption $option)
    {
        $option->delete();

        return redirect()
            ->route('admin.fields.options.index', $field->id)
            ->with('success', 'Option deleted successfully');
    }
}
