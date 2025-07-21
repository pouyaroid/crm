@extends('layouts.app')

@section('title', 'ثبت پرونده جدید')

@section('content')
<div class="container mt-4">
    <h2>ثبت پرونده جدید</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <form action="{{ route('customer-cases.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="customer_id" class="form-label">شناسه مشتری</label>
            <input type="number" name="customer_id" id="customer_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="case_title" class="form-label">عنوان پرونده</label>
            <input type="text" name="case_title" id="case_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea name="description" id="description" rows="4" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="documents" class="form-label">آپلود مدارک (چند فایل)</label>
            <input type="file" name="documents[]" id="documents" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">ثبت پرونده</button>
    </form>
</div>
@endsection
