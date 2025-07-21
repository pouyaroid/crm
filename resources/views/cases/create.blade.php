@extends('layouts.app')

@section('title', 'ایجاد پرونده جدید')

@section('content')
<div class="container">
    <h2>ایجاد پرونده جدید برای مشتری {{ $customer->name }}</h2>

    <form method="POST" action="{{ route('customers.cases.store', $customer->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">عنوان</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="files" class="form-label">آپلود فایل‌ها</label>
            <input type="file" name="files[]" id="files" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">ثبت پرونده</button>
    </form>
</div>
@endsection
