@extends('layouts.app')

@section('title', 'لیست مشتریان')

@section('content')
<style>
    /* IMPORTANT: All styles here are specific to this page and designed to override
    any conflicting global styles, ensuring proper display and responsiveness.
    */

    /* Main container for the page content */
    .page-main-content {
        background: linear-gradient(135deg, #f5faff 0%, #eaf5ff 100%); /* Softer, brighter background for this page */
        min-height: calc(100vh - 60px); /* Adjust based on your header/footer height */
        padding: 30px; /* Generous padding around the content */
        border-radius: 15px; /* Subtle rounded corners for the content area */
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08); /* Soft shadow for the content area */
        margin-top: 20px; /* Space from top (e.g., header/navbar) */
        margin-bottom: 20px; /* Space from bottom (e.g., footer) */
        direction: rtl; /* Ensure RTL for this specific content block */
        text-align: right; /* Ensure text alignment for RTL */
    }

    /* Page Header Section */
    .page-header {
        border-bottom: 3px solid transparent;
        border-image: linear-gradient(to right, #4dc0ff, #80e0ff) 1; /* Lighter, more vibrant blue gradient underline */
        padding-bottom: 15px;
        margin-bottom: 30px;
        align-items: center; /* Center items vertically */
    }
    .page-header h2 {
        font-size: 2.2rem; /* Larger title */
        font-weight: 700; /* Bolder title */
        color: #0056b3; /* Darker blue for text */
        display: flex;
        align-items: center;
        margin-bottom: 0; /* Remove default margin */
    }
    .page-header h2 i {
        font-size: 2.4rem; /* Larger icon */
        margin-left: 15px; /* Space for icon */
        color: #007bff;
    }
    .user-info-box {
        background: linear-gradient(135deg, #ffffff, #f9fcff); /* Subtle light gradient */
        padding: 10px 20px;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        font-size: 0.95rem;
        color: #555;
    }
    .user-info-box strong {
        color: #333;
    }

    /* General Card Styling (for Search form and Table/Card container) */
    .card {
        border-radius: 15px; /* Consistent rounded corners */
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08); /* Lighter, more refined shadow */
        transition: all 0.3s ease-in-out;
        border: none; /* No default border */
        background-color: #ffffff;
    }
    .card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12); /* Slightly more prominent shadow on hover */
        transform: translateY(-2px); /* Subtle lift */
    }

    /* Form Controls and Input Groups */
    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 10px; /* Consistent rounded corners */
        padding: 12px 15px; /* Good padding */
        border: 1px solid #e0e6ed; /* Light, soft border */
        background-color: #f8fbfd; /* Very light background */
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        background-color: #ffffff;
    }
    .input-group-text {
        background-color: #f0f4f8 !important; /* Slightly distinct background */
        border: 1px solid #e0e6ed !important;
        border-radius: 10px 0 0 10px !important; /* Adjust corners for RTL */
        border-left: none !important; /* Remove left border for RTL input group */
        padding: 12px 15px;
        color: #6c757d;
    }
    .input-group .form-control.rounded-end-pill {
        border-radius: 0 10px 10px 0 !important; /* Adjust corners for RTL input group */
        border-right: none !important; /* Remove right border for RTL input group */
    }

    /* Buttons */
    .btn {
        font-weight: 600;
        border-radius: 30px; /* Pill-shaped buttons for primary actions */
        padding: 12px 25px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        color: white; /* Ensure text color is white */
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: linear-gradient(145deg, #4dc0ff 0%, #00aaff 100%); /* Lighter, more vibrant blues */
        border: none;
        border-color: #4dc0ff;
    }
    .btn-primary:hover {
        background: linear-gradient(145deg, #00aaff 0%, #4dc0ff 100%);
    }
    .btn-success {
        background: linear-gradient(145deg, #5cb85c 0%, #4cae4c 100%); /* Lighter, more vibrant greens */
        border: none;
        border-color: #5cb85c;
    }
    .btn-success:hover {
        background: linear-gradient(145deg, #4cae4c 0%, #5cb85c 100%);
    }

    /* Action Buttons in Table/Card */
    .btn-action-sm { /* Custom class for smaller action buttons */
        border-radius: 15px; /* More rounded */
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    .btn-action-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-warning { background-color: #ffc107; border-color: #ffc107; color: #333; }
    .btn-info { background-color: #17a2b8; border-color: #17a2b8; }
    .btn-danger { background-color: #dc3545; border-color: #dc3545; }
    /* Ensure icon margin for RTL in action buttons */
    .btn-action-sm i {
        margin-left: 5px;
    }

    /* Table Styling (for desktop) */
    .table-desktop-view { /* Renamed for clarity */
        display: table; /* Show table on desktop */
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%; /* Ensure table takes full width */
    }
    .table-desktop-view thead th {
        background: linear-gradient(90deg, #4dc0ff, #80e0ff); /* Lighter, more vibrant blue gradient header */
        color: white;
        text-align: center;
        padding: 15px 8px; /* Slightly reduced padding to save space */
        font-weight: 700;
        vertical-align: middle;
        white-space: nowrap; /* Prevent wrapping in headers */
        border: none;
        font-size: 0.9rem; /* Slightly smaller font for headers */
    }
    .table-desktop-view thead tr:first-child th:first-child { border-top-right-radius: 15px; }
    .table-desktop-view thead tr:first-child th:last-child { border-top-left-radius: 15px; }
    .table-desktop-view tbody td {
        text-align: center;
        padding: 10px 6px; /* Reduced padding for more content space */
        font-size: 0.85rem; /* Smaller font for data */
        color: #495057;
        vertical-align: middle;
        white-space: nowrap; /* Keep content in one line */
        overflow: hidden; /* Hide overflow */
        text-overflow: ellipsis; /* Add ellipsis for overflowed text */
        max-width: 100px; /* Set a max-width for columns to control table width */
        border-bottom: 1px solid #f0f2f7;
        border-left: 1px solid #f0f2f7;
        border-right: 1px solid #f0f2f7;
    }
    .table-desktop-view tbody tr:last-child td { border-bottom: none; }
    .table-desktop-view tbody tr:hover td {
        background-color: rgba(0, 123, 255, 0.05);
        transition: background-color 0.2s ease;
    }

    /* Customer Card Styling (for mobile) */
    .customer-card-mobile-view { /* Renamed for clarity */
        /* No display: none here, controlled by d-md-none on parent row */
        background: linear-gradient(160deg, #ffffff 95%, #faffff 100%); /* Brighter white gradient */
        border-radius: 15px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
        border: none;
        position: relative;
        overflow: hidden;
        margin-bottom: 15px; /* Spacing between cards */
    }
    .customer-card-mobile-view:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        border-right: 5px solid #007bff; /* Highlight on hover */
    }
    .customer-card-mobile-view .card-body {
        padding: 20px;
    }
    .customer-card-mobile-view .card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0056b3;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .customer-card-mobile-view .card-title i {
        font-size: 1.4rem;
        color: #007bff;
    }
    .customer-card-mobile-view .card-text-item {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .customer-card-mobile-view .card-text-item strong {
        color: #333;
        min-width: 80px; /* Align labels */
        display: inline-block;
    }
    .customer-card-mobile-view .card-text-item i {
        font-size: 1rem;
        color: #17a2b8;
    }
    .customer-card-mobile-view .card-actions {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #f0f2f7;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }


    /* Animation for table rows and cards */
    .animate-row, .animate-card-item {
        animation: fadeIn 0.6s ease-out forwards;
        /* Removed opacity: 0; to ensure visibility even if animation doesn't trigger */
    }
    @keyframes fadeIn {
        from { transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); } /* Only animate transform and opacity to 1 */
    }
    /* Apply animation delay to stagger items */
    @for ($i = 0; $i < 20; $i++) /* Adjust max number based on your pagination limit */
        .animate-card-item-{{ $i }} { animation-delay: {{ $i * 0.1 }}s; }
    @endfor


    /* Pagination Styling (consistent with previous views) */
    .pagination .page-link {
        border-radius: 50% !important;
        margin: 0 4px;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        border: 1px solid #dee2e6;
        color: #007bff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        transform: scale(1.08);
    }
    .pagination .page-item.disabled .page-link {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Checkbox Styling */
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 0.3rem;
        border: 1px solid #ced4da;
        transition: all 0.2s ease;
    }
    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    /* Specific RTL adjustment for checkbox in table header */
    th .form-check-input {
        position: relative;
        top: 2px;
        float: right;
        margin-left: 0.5rem;
        margin-right: -0.5rem;
    }
    th .form-check-label {
        margin-left: 0;
        margin-right: 0.5rem;
    }


    /* Responsive Adjustments */
    @media (min-width: 768px) { /* Show table on desktop and larger tablets */
        .table-desktop-view {
            display: table !important;
        }
        .customer-cards-mobile-view-container { /* Hide the entire mobile cards container */
            display: none !important;
        }
    }

    @media (max-width: 767.98px) { /* Show cards on small tablets and mobile */
        .table-desktop-view {
            display: none !important;
        }
        .customer-cards-mobile-view-container { /* Show the entire mobile cards container */
            display: flex !important; /* Use flex to manage card layout */
            flex-wrap: wrap; /* Allow cards to wrap */
            gap: 15px; /* Spacing between cards */
        }
        .page-main-content {
            padding: 15px; /* Adjust padding for smaller screens */
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            text-align: right;
            margin-bottom: 20px;
        }
        .page-header h2 {
            font-size: 1.8rem;
            justify-content: flex-start;
            width: 100%;
        }
        .page-header h2 i {
            font-size: 2rem;
        }
        .d-flex.flex-column.flex-lg-row.align-items-lg-center.gap-3 {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            gap: 10px;
        }
        .user-info-box, .btn-success {
            width: 100%; /* Full width for user info and group message button */
            justify-content: center;
        }
        .search-form-tracking .input-group {
            max-width: 100%;
            margin-bottom: 20px;
        }
        .search-form-tracking .form-control, .search-form-tracking .btn-primary {
            padding: 10px 15px;
            font-size: 0.95rem;
        }
        .col-auto .btn {
            margin-top: 10px !important; /* Space between search input and search button */
            width: 100%;
        }
        .pagination .page-link {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) { /* Very small screens / mobile */
        .page-main-content {
            padding: 10px;
        }
        .page-header h2 {
            font-size: 1.6rem;
        }
        .page-header h2 i {
            font-size: 1.8rem;
        }
        .customer-card-mobile-view .card-body {
            padding: 15px;
        }
        .customer-card-mobile-view .card-title {
            font-size: 1.05rem;
        }
        .customer-card-mobile-view .card-title i {
            font-size: 1.3rem;
        }
        .customer-card-mobile-view .card-text-item {
            font-size: 0.85rem;
        }
        .customer-card-mobile-view .card-text-item strong {
            min-width: 70px;
        }
        .customer-card-mobile-view .card-actions .btn {
            font-size: 0.75rem;
            padding: 5px 10px;
        }
        .pagination .page-link {
            width: 35px;
            height: 35px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="page-main-content"> {{-- Wrapper div for page-specific styles --}}
    <div class="container-fluid">
        <div class="d-flex flex-column flex-lg-row justify-content-between page-header mb-4">
            <h2 class="text-primary fw-bold">
                <i class="bi bi-people-fill"></i>لیست مشتریان
            </h2>
            <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3">
                {{-- User Info Box --}}
                <div class="user-info-box d-flex align-items-center justify-content-center flex-wrap">
                    <strong class="text-muted ms-2">کاربر:</strong> {{ auth()->user()->name }}
                    <span class="mx-2 text-muted">|</span>
                    <strong class="text-muted ms-2">نقش:</strong> {{ implode(', ', auth()->user()->getRoleNames()->toArray()) }}
                </div>
                {{-- Send Group Message Button --}}
                <a href="{{ route('customers.select') }}" class="btn btn-success shadow-sm">
                    <i class="bi bi-envelope-fill me-2"></i>ارسال پیام گروهی
                </a>
            </div>
        </div>

        <form method="GET" id="search-form" class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6 col-lg-4">
                        <label for="search" class="form-label fw-medium text-muted">جستجو (نام، شرکت، ایمیل، شماره)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" id="search" class="form-control rounded-end-pill" placeholder="عبارت مورد نظر را وارد کنید" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary shadow-sm mt-4 mt-md-0">
                            <i class="bi bi-funnel me-2"></i>جستجو
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="card shadow-sm rounded-3 overflow-hidden d-none d-md-block table-desktop-view">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="text-white">
                            <tr>
                                @if(auth()->user()->hasRole('admin'))
                                    <th>
                                        <input type="checkbox" id="select-all" class="form-check-input bg-white">
                                        <label for="select-all" class="form-check-label">انتخاب همه</label>
                                    </th>
                                @endif
                                <th>نام شخص</th>
                                <th>نام شرکت</th>
                                <th>نوع شرکت</th>
                                <th>ایمیل</th>
                                <th>آدرس</th>
                                <th>مدیرعامل</th>
                                <th>بانک</th>
                                <th>توضیحات</th>
                                <th>شماره حساب</th>
                                <th>تلفن شرکت</th>
                                <th>تلفن همراه</th>
                                <th>کد ملی</th>
                                <th>کد پستی</th>
                                <th>کد اقتصادی</th>
                                @if(auth()->user()->hasRole('admin'))
                                    <th>عملیات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="customer-table-desktop"> {{-- Unique ID for desktop table body --}}
                            @forelse($customers as $customer)
                                <tr class="animate-row">
                                    @if(auth()->user()->hasRole('admin'))
                                        <td><input type="checkbox" name="selected_customers[]" value="{{ $customer->id }}" class="form-check-input"></td>
                                    @endif
                                    <td>{{ $customer->personal_name }}</td>
                                    <td>{{ $customer->company_name }}</td>
                                    <td>{{ $customer->company_type }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td><span title="{{ $customer->address }}">{{ Str::limit($customer->address, 20, '...') }}</span></td> {{-- Truncate address --}}
                                    <td><span title="{{ $customer->ceo }}">{{ Str::limit($customer->ceo, 15, '...') }}</span></td>
                                    <td><span title="{{ $customer->bank }}">{{ Str::limit($customer->bank, 15, '...') }}</span></td>
                                    <td><span title="{{ $customer->note }}">{{ Str::limit($customer->note, 20, '...') }}</span></td> {{-- Truncate note --}}
                                    <td>{{ $customer->account_number }}</td>
                                    <td>{{ $customer->company_phone }}</td>
                                    <td>{{ $customer->mobile_phone }}</td>
                                    <td>{{ $customer->id_meli }}</td>
                                    <td>{{ $customer->postal_code }}</td>
                                    <td>{{ $customer->code_eghtesadi }}</td>
                                    @if(auth()->user()->hasRole('admin'))
                                        <td>
                                            <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-action-sm">
                                                    <i class="bi bi-pencil me-1"></i>ویرایش
                                                </a>
                                                <a href="{{ route('customers.message.single', $customer->id) }}" class="btn btn-info btn-action-sm">
                                                    <i class="bi bi-envelope me-1"></i>ارسال پیام
                                                </a>
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-action-sm">
                                                        <i class="bi bi-trash me-1"></i>حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->hasRole('admin') ? 16 : 15 }}" class="text-center py-4">
                                        <div class="alert alert-info text-center shadow-sm d-inline-block">هیچ مشتری یافت نشد.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row d-md-none customer-cards-mobile-view-container"> {{-- Hidden on desktop, shown on mobile --}}
            @forelse($customers as $index => $customer)
                <div class="col-12 animate-card-item animate-card-item-{{ $index }}">
                    <div class="card customer-card-mobile-view">
                        <div class="card-body">
                            <h5 class="card-title">
                                @if(auth()->user()->hasRole('admin'))
                                    <input type="checkbox" name="selected_customers_mobile[]" value="{{ $customer->id }}" class="form-check-input me-2">
                                @endif
                                <i class="bi bi-person-circle"></i> {{ $customer->personal_name }}
                            </h5>
                            <p class="card-text-item"><i class="bi bi-building"></i> <strong>شرکت:</strong> {{ $customer->company_name }}</p>
                            <p class="card-text-item"><i class="bi bi-diagram-3"></i> <strong>نوع:</strong> {{ $customer->company_type }}</p>
                            <p class="card-text-item"><i class="bi bi-envelope"></i> <strong>ایمیل:</strong> {{ $customer->email }}</p>
                            <p class="card-text-item"><i class="bi bi-geo-alt"></i> <strong>آدرس:</strong> {{ $customer->address }}</p>
                            <p class="card-text-item"><i class="bi bi-person-badge"></i> <strong>مدیرعامل:</strong> {{ $customer->ceo }}</p>
                            <p class="card-text-item"><i class="bi bi-bank"></i> <strong>بانک:</strong> {{ $customer->bank }}</p>
                            <p class="card-text-item"><i class="bi bi-journal-text"></i> <strong>یادداشت:</strong> {{ $customer->note }}</p>
                            <p class="card-text-item"><i class="bi bi-hash"></i> <strong>شماره حساب:</strong> {{ $customer->account_number }}</p>
                            <p class="card-text-item"><i class="bi bi-telephone-inbound"></i> <strong>تلفن شرکت:</strong> {{ $customer->company_phone }}</p>
                            <p class="card-text-item"><i class="bi bi-phone"></i> <strong>تلفن همراه:</strong> {{ $customer->mobile_phone }}</p>
                            <p class="card-text-item"><i class="bi bi-person-vcard"></i> <strong>کد ملی:</strong> {{ $customer->id_meli }}</p>
                            <p class="card-text-item"><i class="bi bi-mailbox"></i> <strong>کد پستی:</strong> {{ $customer->postal_code }}</p>
                            <p class="card-text-item"><i class="bi bi-cash-stack"></i> <strong>کد اقتصادی:</strong> {{ $customer->code_eghtesadi }}</p>

                            @if(auth()->user()->hasRole('admin'))
                                <div class="card-actions">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-action-sm">
                                        <i class="bi bi-pencil me-1"></i>ویرایش
                                    </a>
                                    <a href="{{ route('customers.message.single', $customer->id) }}" class="btn btn-info btn-action-sm">
                                        <i class="bi bi-envelope me-1"></i>ارسال پیام
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action-sm">
                                            <i class="bi bi-trash me-1"></i>حذف
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm d-inline-block w-100">هیچ مشتری یافت نشد.</div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div> {{-- End of .page-main-content --}}
@endsection

@section('scripts')
{{-- Page-specific JavaScript --}}
<script>
    $(function () {
        // AJAX Search Form Submission
        $('#search-form').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            let query = $('#search').val(); // Get search query
            $.ajax({
                url: '{{ route("customers.ajax") }}', // Your AJAX route for customers
                type: 'GET',
                data: { search: query },
                success: function (response) {
                    // Update both desktop table and mobile cards
                    $('#customer-table-desktop').html(response.desktop_html);
                    $('.customer-cards-mobile-view-container').html(response.mobile_html);
                    // Re-attach select-all listener if needed (though it's on the main checkbox)
                    $('#select-all').prop('checked', false); // Uncheck "select all" after search
                },
                error: function () {
                    // Display an error message if AJAX fails
                    alert('خطا در دریافت اطلاعات مشتریان. لطفا دوباره تلاش کنید.');
                }
            });
        });

        // Select All Checkbox functionality for desktop table
        $('#select-all').on('click', function () {
            $('input[name="selected_customers[]"]').prop('checked', this.checked);
            // If you want select-all to also affect mobile cards, you'd need to
            // target 'selected_customers_mobile[]' as well.
            $('input[name="selected_customers_mobile[]"]').prop('checked', this.checked);
        });
    });
</script>
@endsection
