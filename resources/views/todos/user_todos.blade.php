@extends('layouts.app')

@section('content')
<div class="container py-4 text-end">
    <h4 class="fw-bold mb-4">تسک‌های کاربر: {{ $user->name }}</h4>

    <a href="{{ route('todos.index') }}" class="btn btn-secondary mb-3">بازگشت به لیست کاربران</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-end align-middle">
            <thead class="table-dark">
                <tr>
                    <th>عنوان</th>
                    <th>توضیحات</th>
                    <th>تاریخ مهلت</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($todos as $todo)
                    <tr>
                        <td>{{ $todo->title }}</td>
                        <td>{{ Str::limit($todo->description, 50) }}</td>
                        <td>{{ $todo->due_date ? \Morilog\Jalali\Jalalian::fromDateTime($todo->due_date)->format('%Y/%m/%d') : '-' }}</td>
                        <td>
                            <span class="badge {{ $todo->is_done ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $todo->is_done ? 'انجام شده' : 'در حال انجام' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('todos.show', $todo->id) }}" class="btn btn-sm btn-info">مشاهده</a>
                            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-warning">ویرایش</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $todos->links() }}
    </div>
</div>
@endsection
