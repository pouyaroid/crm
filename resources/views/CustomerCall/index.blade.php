@extends('layouts.app')

@section('title', 'سابقه تماس')

@section('content')
{{-- اضافه کردن کتابخانه های Bootstrap 5 و RTL --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" xintegrity="sha384-dpuaG1suBy+9ZkM5Wg4iJdCPEzvD5OIlz+rjOStP3h+LPNxsyJmFjSyt4dE+gS6" crossorigin="anonymous">
<style>
    /* استایل‌های سفارشی برای زیبایی بیشتر و افکت هاور */
    body {
        background-color: #f0f2f5;
        direction: rtl; /* جهت‌دهی کل صفحه به راست */
        font-family: 'Vazirmatn', sans-serif;
    }
    .card-call {
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: none;
        background-color: #ffffff;
    }
    .card-call:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
    }
    .card-title {
        color: #007bff; /* رنگ آبی برجسته برای عنوان */
        font-size: 1.1rem;
        font-weight: 600;
    }
    .card-text {
        color: #495057;
        font-size: 0.95rem;
    }
    .text-muted {
        font-size: 0.8rem;
    }
    .header-section {
        border-bottom: 2px solid #e9ecef;
    }
</style>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5 header-section">
        <h2 class="text-primary fw-bold">
            {{ $customer->company_name }}
        </h2>
        <span class="text-secondary h5">سابقه تماس‌ها</span>
    </div>
    
    {{-- نمایش پیغام موفقیت با استایل بوت استرپ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center rounded-pill" role="alert">
            <span class="fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
        </div>
    @endif
    
    {{-- نمایش در صورت خالی بودن لیست تماس‌ها --}}
    @if($calls->isEmpty())
        <div class="card p-5 text-center text-muted border-dashed">
            <p class="mb-0 fs-5">هیچ تماسی برای این مشتری ثبت نشده است.</p>
        </div>
    @else
        {{-- لیست تماس‌ها در یک گرید دو ستونه --}}
        <div class="row g-4">
            @foreach($calls as $call)
                <div class="col-12 col-md-6">
                    <div class="card card-call h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                {{-- نام کاربر و تاریخ تماس --}}
                                <h6 class="text-muted fw-bold">{{ $call->user->name ?? '---' }}</h6>
                                <span class="text-muted">{{ \Morilog\Jalali\Jalalian::fromDateTime($call->called_at)->format('Y/m/d H:i') }}</span>
                            </div>
                            {{-- عنوان تماس --}}
                            <h5 class="card-title mb-2">{{ $call->title ?? '---' }}</h5>
                            {{-- توضیحات تماس --}}
                            <p class="card-text text-dark flex-grow-1">{{ $call->description ?? '---' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection
