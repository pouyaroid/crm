@extends('layouts.app')

@section('title', 'ایمپورت مشتریان')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">ایمپورت مشتریان از فایل CSV</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card p-4">
        <p>فایل CSV شما باید دارای ستون‌های زیر باشد:</p>
        <ul class="list-unstyled">
            <li>نام شرکت</li>
            <li>نوع شرکت</li>
            <li>نام مسئول</li>
            <li>ایمیل</li>
            <li>آدرس</li>
            <li>مدیر عامل</li>
            <li>بانک</li>
            <li>یادداشت</li>
            <li>شماره حساب</li>
            <li>تلفن شرکت</li>
            <li>تلفن همراه</li>
            <li>کد ملی</li>
            <li>کد پستی</li>
            <li>کد اقتصادی</li>
        </ul>

        <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" class="mt-4">
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