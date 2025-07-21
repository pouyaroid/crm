@extends('layouts.app')

@section('title', 'لیست مشتریان')

@section('content')
<div class="container-fluid mt-4">

    {{-- هدر و دکمه ارسال پیام --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <h2 class="text-primary fw-bold mb-0">لیست مشتریان</h2>
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">
            <div class="text-muted">
                <strong>کاربر:</strong> {{ auth()->user()->name }} |
                <strong>نقش:</strong> {{ implode(', ', auth()->user()->getRoleNames()->toArray()) }}
            </div>
            <a href="{{ route('customers.select') }}" class="btn btn-success shadow-sm rounded-pill px-4">
                <i class="bi bi-envelope-fill me-2"></i>ارسال پیام گروهی
            </a>
        </div>
    </div>

    {{-- فرم جستجو --}}
    <form method="GET" id="search-form" class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="search" class="form-label fw-medium text-muted">جستجو (نام، شرکت، ایمیل، شماره)</label>
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

    {{-- جدول مشتریان - دسکتاپ --}}
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden d-none d-md-block">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            @if(auth()->user()->hasRole('admin'))
                                <th><input type="checkbox" id="select-all" class="form-check-input bg-white"></th>
                            @endif
                            <th>نام شخص</th>
                            <th>نام شرکت</th>
                            <th>ایمیل</th>
                            <th>موبایل</th>
                            <th>آدرس</th>
                            <th>نوع شرکت</th>
                            <th>مدیرعامل</th>
                            <th>بانک</th>
                            <th>توضیحات</th>
                            <th>شماره حساب</th>
                            <th>تلفن شرکت</th>
                            <th>کد ملی</th>
                            <th>کد پستی</th>
                            <th>کد اقتصادی</th>
                            @if(auth()->user()->hasRole('admin'))
                                <th>عملیات</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="customer-table-desktop">
                        @foreach($customers as $customer)
                            <tr class="animate-row">
                                @if(auth()->user()->hasRole('admin'))
                                    <td><input type="checkbox" name="selected_customers[]" value="{{ $customer->id }}" class="form-check-input"></td>
                                @endif
                                <td>{{ $customer->personal_name }}</td>
                                <td>{{ $customer->company_name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->mobile_phone }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->company_type }}</td>
                                <td>{{ $customer->ceo }}</td>
                                <td>{{ $customer->bank }}</td>
                                <td>{{ $customer->note }}</td>
                                <td>{{ $customer->account_number }}</td>
                                <td>{{ $customer->company_phone }}</td>
                                <td>{{ $customer->id_meli }}</td>
                                <td>{{ $customer->postal_code }}</td>
                                <td>{{ $customer->code_eghtesadi }}</td>
                                @if(auth()->user()->hasRole('admin'))
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm"><i class="bi bi-pencil me-1"></i>ویرایش</a>
                                            <a href="{{ route('customers.message.single', $customer->id) }}" class="btn btn-info btn-sm rounded-pill px-3 shadow-sm"><i class="bi bi-envelope me-1"></i>پیام</a>
                                            <a href="{{ route('cases.create', $customer->id) }}" class="btn btn-secondary btn-sm rounded-pill px-3 shadow-sm"><i class="bi bi-folder-plus me-1"></i>پرونده جدید</a>
                                            <a href="{{ route('customers.cases.index', $customer->id) }}" class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm"><i class="bi bi-folder2-open me-1"></i>پرونده‌ها</a>
                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm"><i class="bi bi-trash me-1"></i>حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- کارت مشتریان - موبایل --}}
    <div class="d-md-none">
        <div class="row row-cols-1 g-3" id="customer-cards-mobile">
            @foreach($customers as $customer)
                <div class="col animate-row">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $customer->personal_name }}</h5>
                            <p><strong>شرکت:</strong> {{ $customer->company_name }}</p>
                            <p><strong>ایمیل:</strong> {{ $customer->email }}</p>
                            <p><strong>موبایل:</strong> {{ $customer->mobile_phone }}</p>
                            <p><strong>آدرس:</strong> {{ $customer->address }}</p>
                            <p><strong>نوع شرکت:</strong> {{ $customer->company_type }}</p>
                            <p><strong>مدیرعامل:</strong> {{ $customer->ceo }}</p>
                            <p><strong>بانک:</strong> {{ $customer->bank }}</p>
                            <p><strong>شماره حساب:</strong> {{ $customer->account_number }}</p>
                            <p><strong>تلفن شرکت:</strong> {{ $customer->company_phone }}</p>
                            <p><strong>کد ملی:</strong> {{ $customer->id_meli }}</p>
                            <p><strong>کد پستی:</strong> {{ $customer->postal_code }}</p>
                            <p><strong>کد اقتصادی:</strong> {{ $customer->code_eghtesadi }}</p>
                            <p><strong>توضیحات:</strong> {{ $customer->note }}</p>

                            @if(auth()->user()->hasRole('admin'))
                                <hr class="my-3">
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm rounded-pill w-100"><i class="bi bi-pencil me-1"></i>ویرایش</a>
                                    <a href="{{ route('customers.message.single', $customer->id) }}" class="btn btn-info btn-sm rounded-pill w-100"><i class="bi bi-envelope me-1"></i>پیام</a>
                                    <a href="{{ route('cases.create', $customer->id) }}" class="btn btn-secondary btn-sm rounded-pill w-100"><i class="bi bi-folder-plus me-1"></i>پرونده جدید</a>
                                    <a href="{{ route('customers.cases.index', $customer->id) }}" class="btn btn-dark btn-sm rounded-pill w-100"><i class="bi bi-folder2-open me-1"></i>پرونده‌ها</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill w-100"><i class="bi bi-trash me-1"></i>حذف</button>
                                    </form>
                                </div>
                            @endif
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
    const tableContainer = document.getElementById('customer-table-desktop');
    const cardContainer = document.getElementById('customer-cards-mobile');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // جلوگیری از بارگذاری مجدد صفحه

        const query = searchInput.value;

        fetch(`{{ route('customers.ajax') }}?search=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                tableContainer.innerHTML = data.table;
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
