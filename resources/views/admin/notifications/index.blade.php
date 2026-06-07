@extends('layouts/contentNavbarLayout')

@section('title', __('notifications.page_title'))

@section('page-style')
<style>
    .notif-card {
        border: 1px solid #e4e6ef;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 12px;
        background: #fff;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        transition: .2s ease;
    }
    .notif-card.unread {
        background: #f5f3ff;
        border-color: #6a5af9;
    }
    .notif-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #ece9ff;
        color: #6a5af9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .notif-body { flex: 1; }
    .notif-title { font-weight: 700; color: #2b2f48; margin: 0 0 3px; }
    .notif-text { color: #666; font-size: 14px; margin: 0; }
    .notif-time { color: #999; font-size: 12px; margin-top: 4px; }
    .notif-badge {
        display: inline-block;
        background: #6a5af9;
        color: #fff;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 6px;
        margin-inline-start: 8px;
    }
    .notif-empty {
        text-align: center;
        padding: 50px 20px;
        color: #999;
    }
    .notif-empty i { font-size: 50px; color: #d0d0e0; }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        {{ __('notifications.page_title') }}
        @if($unreadCount > 0)
            <span class="notif-badge">{{ $unreadCount }}</span>
        @endif
    </h4>

    @if($unreadCount > 0)
        <form action="{{ route('admin.notifications.read_all') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary">
                {{ __('notifications.mark_all_read') }}
            </button>
        </form>
    @endif
</div>

@forelse($notifications as $notification)
    <div class="notif-card {{ $notification->is_read ? '' : 'unread' }}">
        <div class="notif-icon">
            <i class="bx bx-bell"></i>
        </div>

        <div class="notif-body">
            <p class="notif-title">{{ $notification->title }}</p>
            <p class="notif-text">{{ $notification->body }}</p>
            <div class="notif-time">{{ $notification->created_at->diffForHumans() }}</div>
        </div>

        @if(!$notification->is_read)
            <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    {{ __('notifications.mark_read') }}
                </button>
            </form>
        @endif
    </div>
@empty
    <div class="notif-empty">
        <i class="bx bx-bell-off"></i>
        <p class="mt-2">{{ __('notifications.empty') }}</p>
    </div>
@endforelse

<div class="mt-3">
    {{ $notifications->links() }}
</div>

@endsection
