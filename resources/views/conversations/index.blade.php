@extends('layouts/contentNavbarLayout')

@section('title', __('conversations.title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">{{ __('conversations.list_title') }}</h4>
    </div>

    <!-- Sneat Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('conversations.all_conversations') }}</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('conversations.service') }}</th>
                        <th>{{ __('conversations.user') }}</th>
                        <th>{{ __('conversations.provider') }}</th>
                        <th>{{ __('conversations.last_message') }}</th>
                        <th>{{ __('conversations.updated_at') }}</th>
                        <th>{{ __('conversations.show') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($conversations as $conversation)
                        <tr>
                            <td>{{ $conversation->id }}</td>

                            <td>{{ $conversation->service?->title ?? '—' }}</td>

                            <td>{{ $conversation->participants->first()?->name ?? '—' }}</td>

                            <td>{{ $conversation->participants->last()?->name ?? '—' }}</td>

                            <td>
                                {{ $conversation->lastMessage?->content
                                    ? Str::limit($conversation->lastMessage->content, 30)
                                    : '—' }}
                            </td>

                            <td>{{ $conversation->updated_at->format('Y-m-d H:i') }}</td>

                            <td>
                                <a href="{{ route('admin.conversations.show', $conversation->id) }}"
                                   class="btn btn-sm btn-primary">
                                    {{ __('conversations.show_btn') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                {{ __('conversations.no_conversations') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
