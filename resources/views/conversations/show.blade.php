@extends('layouts/contentNavbarLayout')

@section('title', __('conversations.show_title'))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">{{ __('conversations.conversation_details') }}</h4>

        <a href="{{ route('admin.conversations.index') }}" class="btn btn-secondary">
            {{ __('conversations.back') }}
        </a>
    </div>

    <!-- Conversation Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ __('conversations.messages') }}</h5>
        </div>

        <div class="card-body" style="max-height: 600px; overflow-y: auto;">

            @forelse ($conversation->messages as $message)
                <div class="mb-4">

                    <div class="d-flex justify-content-between">
                        <strong>{{ $message->sender->name }}</strong>
                        <small>{{ $message->created_at->format('Y-m-d H:i') }}</small>
                    </div>

                    <div class="border rounded p-3 mt-2 bg-light">
                        {{ $message->body }}
                    </div>

                </div>
            @empty
                <p class="text-center text-muted">{{ __('conversations.no_messages') }}</p>
            @endforelse

        </div>
    </div>

</div>
@endsection
