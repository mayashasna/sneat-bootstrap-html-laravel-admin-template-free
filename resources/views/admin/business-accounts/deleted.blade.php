@extends('layouts/contentNavbarLayout')

@section('content')

<div class="container">

    <h1 class="mb-2"><i class="bx bx-trash"></i> {{ __('business.deleted_title') }}</h1>
    <p class="text-muted mb-4">{{ __('business.deleted_subtitle') }}</p>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table premium-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('business.column_name') }}</th>
                        <th>{{ __('business.column_city') }}</th>
                        <th>{{ __('business.column_activity') }}</th>
                        <th>{{ __('business.column_deleted_at') }}</th>
                        <th>{{ __('business.column_actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{ $account->id }}</td>

                            <td>{{ $account->name_ar }}</td>

                            <td>{{ $account->city->name_ar }}</td>

                            <td>{{ $account->activityType->name_ar }}</td>

                            <td>{{ $account->deleted_at->format('Y-m-d H:i') }}</td>

                            <td>
                                <form action="{{ route('admin.business-accounts.restore', $account->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        <i class="bx bx-undo"></i> {{ __('business.btn_restore') }}
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
