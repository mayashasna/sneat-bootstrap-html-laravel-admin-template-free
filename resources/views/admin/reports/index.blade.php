@extends('layouts/contentNavbarLayout')

@section('title', __('admin.reports.title'))

@section('content')

<h4 class="fw-bold py-3 mb-4">{{ __('admin.reports.title') }}</h4>


<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>{{ __('admin.reports.id') }}</th>
                    <th>{{ __('admin.reports.user') }}</th>
                    <th>{{ __('admin.reports.service') }}</th>
                    <th>{{ __('admin.reports.reason') }}</th>
                    <th>{{ __('admin.reports.status') }}</th>
                    <th>{{ __('admin.reports.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->user->name }}</td>

                        <td>
                            <a href="{{ route('admin.reports.show', $report->id) }}" class="text-primary fw-bold">
                                {{ $report->service->title_en }}
                            </a>
                        </td>

                        <td>{{ $report->reason }}</td>

                        <td>
                            <span class="badge bg-label-{{ $report->status_color }}">
                                {{ __('admin.reports.' . ($report->status ?? 'pending')) }}
                            </span>
                        </td>

                        <td class="d-flex gap-2">

                            {{-- View --}}
                            <a href="{{ route('admin.reports.show', $report->id) }}"
                               class="btn btn-sm btn-info d-flex align-items-center gap-1">
                                <i class="ti ti-eye"></i>
                                {{ __('admin.reports.view') }}
                            </a>

                            {{-- Update --}}
                            @if($report->status === 'pending' || $report->status === null)
                                <form action="{{ route('admin.reports.action', $report->id) }}"
                                      method="POST" class="d-flex gap-2">
                                    @csrf

                                    <select name="status" class="form-select form-select-sm rounded" style="max-width: 150px;">
                                        <option value="accepted">{{ __('admin.reports.accepted') }}</option>
                                        <option value="rejected">{{ __('admin.reports.rejected') }}</option>
                                        <option value="ignored">{{ __('admin.reports.ignored') }}</option>
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                                        <i class="ti ti-check"></i>
                                        {{ __('admin.reports.update') }}
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="mt-3 px-3">
        {{ $reports->links() }}
    </div>
</div>

@endsection
