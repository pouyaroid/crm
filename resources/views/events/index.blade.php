@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>لیست رویدادها</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">ایجاد رویداد جدید</a>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>عنوان</th>
                    <th>محل برگزاری</th>
                    <th>تاریخ شروع</th>
                    <th>تاریخ پایان</th>
                    <th>ایجادکننده</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->event_date_jalali }}</td>
                    <td>{{ $event->end_date_jalali }}</td>
                    <td>{{ $event->user->name }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> ویرایش
                        </a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این رویداد مطمئن هستید؟');">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection