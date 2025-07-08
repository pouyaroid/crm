@extends('layouts.app')

@section('content')
<div class="container py-4 text-end">
    <h4 class="fw-bold mb-4">ویرایش تسک</h4>

    <form method="POST" action="{{ route('todos.update', $todo->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">عنوان</label>
            <input type="text" name="title" class="form-control" value="{{ $todo->title }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea name="description" class="form-control" rows="4">{{ $todo->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">تاریخ مهلت</label>
            <input type="date" name="due_date" class="form-control" value="{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_done" value="1" {{ $todo->is_done ? 'checked' : '' }}>
            <label class="form-check-label">انجام شده</label>
        </div>

        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        <a href="{{ route('todos.index') }}" class="btn btn-secondary">بازگشت</a>
    </form>
</div>
@endsection
