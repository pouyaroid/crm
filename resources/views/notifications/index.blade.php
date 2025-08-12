@extends('layouts.app')

@section('title', 'اعلان‌ها')

@section('content')
    <header class="my-4 text-center">
        <h3 class="display-4">لیست اعلان‌ها</h3>
    </header>

    <ul class="list-group shadow-lg">
        @forelse ($notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center notification-item">
                <div>
                    @php
                        $type = class_basename($notification->type);
                    @endphp

                    @if ($type === 'ReminderNotification')
                        🕒 <strong>یادآور:</strong>
                        {{ $notification->data['message'] ?? 'یادآور جدید دارید.' }}
                    @else
                        🔔 <strong>اعلان:</strong>
                        {{ $notification->data['message'] ?? 'اعلان جدید' }}
                    @endif

                    <small class="text-muted d-block mt-1">{{ $notification->created_at->diffForHumans() }}</small>
                </div>

                @if ($notification->read_at)
                    <span class="badge bg-success">خوانده‌شده</span>
                @else
                    <a href="{{ route('notifications.mark', $notification->id) }}" class="btn btn-sm btn-primary"> خوانده شد</a>
                @endif
            </li>
        @empty
            <li class="list-group-item">اعلانی وجود ندارد.</li>
        @endforelse
    </ul>

    <style>
        .notification-item {
            transition: background-color 0.3s ease;
        }

        .notification-item:hover {
            background-color: #dbf7e0;
        }

        @media (max-width: 768px) {
            .notification-item {
                flex-direction: column;
                align-items: start;
            }
        }
    </style>
@endsection
