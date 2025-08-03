@extends('layouts.app') @section('content')
<div class="container">
    <h2 class="mb-4">ایمپورت مشتریان احتمالی از فایل CSV</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4">
        <p>برای ایمپورت داده‌ها، یک فایل CSV را انتخاب کنید. ستون‌های فایل شما باید شامل موارد زیر باشد (به ترتیب یا با عنوان ستون):</p>
        <ul class="list-unstyled">
            <li>نام</li>
            <li>تلفن</li>
            <li>شرکت</li>
            <li>منبع</li>
            <li>سطح علاقه</li>
            <li>یادداشت</li>
            <li>وضعیت</li>
        </ul>
        <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">فایل CSV را انتخاب کنید:</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">شروع ایمپورت</button>
        </form>
    </div>
</div>
@endsection