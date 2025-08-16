@extends('layouts.app')

@section('title', 'لیست مشتریان')

@section('content')
<div class="container-fluid mt-4">

    {{-- هدر و دکمه ارسال پیام --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <h2 class="text-primary fw-bold mb-0">📋 لیست مشتریان</h2>
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
            <div class="text-muted small">
                <strong>کاربر:</strong> {{ auth()->user()->name }} |
                <strong>نقش:</strong> {{ implode(', ', auth()->user()->getRoleNames()->toArray()) }}
            </div>
            <a href="{{ route('customers.select') }}" class="btn btn-success shadow-sm rounded-pill px-4">
                <i class="bi bi-envelope-fill me-2"></i>ارسال پیام گروهی
            </a>
        </div>
    </div>

    {{-- دکمه‌های Export و Import --}}
    <div class="mb-4 d-flex flex-column flex-md-row gap-2">
        <a href="{{ route('customers.export') }}" class="btn btn-info shadow-sm rounded-pill px-4">
            <i class="bi bi-download me-1"></i> خروجی CSV
        </a>
        <a href="{{ route('customers.import.form') }}" class="btn btn-secondary shadow-sm rounded-pill px-4">
            <i class="bi bi-upload me-1"></i> ایمپورت فایل
        </a>
    </div>

    {{-- فرم جستجو --}}
    <form method="GET" id="search-form" class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="search" class="form-label fw-medium text-muted">🔍 جستجو (نام، شرکت، ایمیل، شماره)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" id="search" class="form-control border-start-0 rounded-end-pill" placeholder="عبارت مورد نظر را وارد کنید">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">جستجو</button>
                </div>
            </div>
        </div>
    </form>

    {{-- کارت مشتریان --}}
    <div id="customer-cards-mobile">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($customers as $customer)
                <div class="col animate-row">
                    <div class="customer-card card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title text-primary fw-bold mb-1">{{ $customer->personal_name }}</h5>
                                    <p class="card-text text-muted small mb-0">{{ $customer->company_name }}</p>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseCard-{{ $customer->id }}" aria-expanded="false"
                                    aria-controls="collapseCard-{{ $customer->id }}">
                                    مشاهده جزئیات
                                </button>
                            </div>

                            <div class="collapse" id="collapseCard-{{ $customer->id }}">
                                <hr class="my-3">
                                <ul class="list-unstyled small text-muted">
                                    <li><i class="bi bi-envelope text-primary me-1"></i> <strong>ایمیل:</strong> {{ $customer->email }}</li>
                                    <li><i class="bi bi-phone text-success me-1"></i> <strong>موبایل:</strong> {{ $customer->mobile_phone }}</li>
                                    <li><i class="bi bi-geo-alt text-danger me-1"></i> <strong>آدرس:</strong> {{ $customer->address }}</li>
                                    <li><i class="bi bi-building text-warning me-1"></i> <strong>نوع شرکت:</strong> {{ $customer->company_type }}</li>
                                    <li><i class="bi bi-person-badge text-info me-1"></i> <strong>مدیرعامل:</strong> {{ $customer->ceo }}</li>
                                    <li><i class="bi bi-bank text-secondary me-1"></i> <strong>بانک:</strong> {{ $customer->bank }}</li>
                                    <li><i class="bi bi-credit-card text-dark me-1"></i> <strong>شماره حساب:</strong> {{ $customer->account_number }}</li>
                                    <li><i class="bi bi-telephone text-primary me-1"></i> <strong>تلفن شرکت:</strong> {{ $customer->company_phone }}</li>
                                    <li><i class="bi bi-card-text text-success me-1"></i> <strong>کد ملی:</strong> {{ $customer->id_meli }}</li>
                                    <li><i class="bi bi-mailbox text-warning me-1"></i> <strong>کد پستی:</strong> {{ $customer->postal_code }}</li>
                                    <li><i class="bi bi-briefcase text-info me-1"></i> <strong>کد اقتصادی:</strong> {{ $customer->code_eghtesadi }}</li>
                                    <li><i class="bi bi-chat-left-text text-muted me-1"></i> <strong>توضیحات:</strong> {{ $customer->note }}</li>
                                </ul>
                            </div>

                            <div class="mt-auto pt-3">
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                    @if(auth()->user()->hasAnyRole(['admin', 'sales_manager', 'management', 'sales_agent', 'marketing_manager', 'marketing_user']))
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-pencil me-1"></i>ویرایش
                                        </a>
                                        <a href="{{ route('customers.message.single', $customer->id) }}" class="btn btn-info btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-envelope me-1"></i>پیام
                                        </a>
                                        <a href="{{ route('cases.create', $customer->id) }}" class="btn btn-secondary btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-folder-plus me-1"></i>پرونده جدید
                                        </a>
                                        <a href="{{ route('customers.cases.index', $customer->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-folder2-open me-1"></i>پرونده‌ها
                                        </a>
                                        <a href="{{ route('customer.calls.create', $customer->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-telephone-plus me-1"></i>ثبت تماس
                                        </a>
                                        <a href="{{ route('customer.calls.index', $customer->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-clock-history me-1"></i>سابقه تماس
                                        </a>
                                    @endif
                                    @if(auth()->user()->hasAnyRole(['admin', 'management', 'marketing_manager', 'sales_manager']))
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm">
                                                <i class="bi bi-trash me-1"></i>حذف
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- عدم وجود مشتری --}}
    @if($customers->isEmpty())
        <div class="alert alert-info text-center mt-4 shadow-sm">هیچ مشتری یافت نشد.</div>
    @endif

    {{-- صفحه‌بندی --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $customers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('search-form');
    const searchInput = document.getElementById('search');
    const cardContainer = document.getElementById('customer-cards-mobile');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const query = searchInput.value;
        fetch(`{{ route('customers.ajax') }}?search=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                cardContainer.innerHTML = data.cards;
            })
            .catch(error => {
                console.error('خطا در جستجوی Ajax:', error);
                alert("خطایی در جستجو رخ داد.");
            });
    });
});
</script>
@endsection

@push('styles')
<style>
    .customer-card {
        transition: all 0.3s ease-in-out;
        border: 1px solid #f0f0f0;
    }
    .customer-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-color: #007bff30;
    }
</style>
@endpush
