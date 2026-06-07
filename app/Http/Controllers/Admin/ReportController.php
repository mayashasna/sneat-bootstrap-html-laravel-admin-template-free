<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'service.business.user'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::with(['user', 'service.business.user'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function action(Request $request, $reportId)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,ignored',
        ]);

        $report = Report::findOrFail($reportId);

        if ($report->status !== 'pending' && $report->status !== null) {
            return redirect()
                ->route('admin.reports.show', $reportId)
                ->with('error', __('admin.reports.locked'));
        }

        $report->update(['status' => $request->status]);

        return redirect()
            ->route('admin.reports.show', $reportId)
            ->with('success', __('admin.reports.updated'));
    }
}
