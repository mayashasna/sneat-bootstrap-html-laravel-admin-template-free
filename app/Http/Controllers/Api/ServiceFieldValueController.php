<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceFieldValue;
use Illuminate\Http\Request;

class ServiceFieldValueController extends Controller
{
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'fields' => 'required|array',
        ]);

        foreach ($request->fields as $fieldId => $value) {
            ServiceFieldValue::updateOrCreate(
                [
                    'service_id' => $service->id,
                    'field_id'   => $fieldId,
                ],
                [
                    'value' => $value,
                ]
            );
        }

        return response()->json([
            'status'  => true,
            'message' => 'Dynamic fields saved successfully',
        ]);
    }
}
