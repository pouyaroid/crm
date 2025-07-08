@extends('layouts.app')

@section('content')
<style>
    @import url('https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css');

    body {
        font-family: 'Vazir', sans-serif !important;
        direction: rtl;
        background-color: #f8f9fa;
    }

    .form-container {
        background: #fff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease-in-out;
    }

    .form-container:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .btn-custom {
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 0.6rem;
    }

    .btn-success {
        background-color: #198754;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .header-title {
        font-weight: 700;
        font-size: 1.5rem;
        color: #0d6efd;
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 1.5rem;
        }

        .header-title {
            font-size: 1.25rem;
        }
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="form-container text-end">
                <a href="{{ route('todos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> افزودن تسک جدید
                </a>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('todos.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان تسک <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="مثلاً: پیگیری ایمیل مشتری">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="توضیحات کامل درباره تسک بنویسید...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">تاریخ مهلت</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                    </div>

                    <div class="d-flex gap-2 mt-4 justify-content-end flex-wrap">
                        <a href="{{ route('todos.index') }}" class="btn btn-secondary btn-custom">بازگشت</a>
                        <button type="submit" class="btn btn-success btn-custom">ذخیره تسک</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
