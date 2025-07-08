@extends('layouts.app')

@section('content')
<div class="container py-4 text-end">
    <h4 class="fw-bold mb-4">لیست کاربران و تسک‌ها</h4>

    <div class="row">
        @foreach($users as $user)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">تعداد تسک‌ها: {{ $user->todos->count() }}</p>
                        <a href="{{ route('todos.user', $user->id) }}" class="btn btn-primary">مشاهده تسک‌ها</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection