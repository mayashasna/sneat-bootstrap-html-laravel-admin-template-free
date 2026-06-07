<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, $serviceId)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $user = $request->user();
        $service = Service::findOrFail($serviceId);

        $report = Report::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'reason' => $request->reason,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Report submitted successfully',
            'data' => $report,
        ]);
    }
}
