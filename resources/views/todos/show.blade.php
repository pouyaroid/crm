@extends('layouts.app')

@section('content')
<div class="container py-4 text-end">
    <h4 class="fw-bold mb-4">جزئیات تسک</h4>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $todo->title }}</h5>
            <p class="card-text">{{ $todo->description }}</p>
            <p><strong>تاریخ مهلت:</strong> {{ $todo->due_date ? \Morilog\Jalali\Jalalian::fromDateTime($todo->due_date)->format('%Y/%m/%d') : 'ندارد' }}</p>
            <p><strong>وضعیت:</strong> 
                <span class="badge {{ $todo->is_done ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $todo->is_done ? 'انجام شده' : 'در حال انجام' }}
                </span>
            </p>

            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning">ویرایش</a>
            <a href="{{ route('todos.index') }}" class="btn btn-secondary">بازگشت</a>
        </div>
    </div>
</div>
@endsection
