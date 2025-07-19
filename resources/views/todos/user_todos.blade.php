{{-- resources/views/todos/user_todos.blade.php --}}@extends('layouts.app')

@section('content')
<div class="container py-4 text-end">
    <h4 class="fw-bold mb-4">تسک‌های {{ $user->name }}</h4>

    @if($todos->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>عنوان تسک</th>
                        <th>توضیحات</th>
                        <th>تاریخ موعد</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todos as $todo)
                    <tr>
                        <td>{{ $todo->title }}</td>
                        <td>{{ Str::limit($todo->description, 40) }}</td>
                        <td>{{ $todo->due_date ? \Illuminate\Support\Carbon::parse($todo->due_date)->format('Y/m/d') : '-' }}</td>
                        <td>
                            @if($todo->is_done)
                                <span class="badge bg-success">انجام شده</span>
                            @else
                                <span class="badge bg-warning text-dark">در انتظار</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('todos.show', $todo->id) }}" class="btn btn-sm btn-info">مشاهده</a>
                            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-warning">ویرایش</a>
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- نمایش صفحه‌بندی --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $todos->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-warning text-center">هیچ تسکی برای نمایش وجود ندارد.</div>
    @endif
</div>
@endsection
