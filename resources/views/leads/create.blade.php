@extends('layouts.app')

@section('title', 'ثبت مشتری احتمالی جدید')

@section('content')
{{-- Custom Styles for this specific page ONLY --}}
<style>
    /* Page-specific background and overall container styling */
    .page-wrapper-lead-create {
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

    /* Form Card Styling */
    .lead-form-card {
        background: linear-gradient(160deg, #ffffff 95%, #faffff 100%); /* Brighter white gradient */
        border-radius: 20px; /* More rounded corners */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Soft, deep shadow */
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Smooth transition */
        border: none; /* Remove default border */
        padding: 30px; /* Generous padding inside the card */
    }
    .lead-form-card:hover {
        transform: translateY(-5px); /* Subtle lift on hover */
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
    }

    /* Page Title Styling */
    .page-title-lead-create {
        font-size: 2.2rem; /* Larger, more prominent title */
        font-weight: 800; /* Extra bold */
        color: #0056b3; /* Darker blue */
        text-align: center;
        margin-bottom: 40px; /* More space below title */
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        position: relative;
        padding-bottom: 15px;
    }
    .page-title-lead-create::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 120px; /* Underline width */
        height: 4px;
        background: linear-gradient(to right, #4dc0ff, #80e0ff); /* Light blue gradient underline */
        border-radius: 2px;
    }
    .page-title-lead-create i {
        font-size: 2.5rem; /* Larger icon */
        color: #007bff;
        text-shadow: 1px 1px 3px rgba(0, 123, 255, 0.2);
    }

    /* Form Labels */
    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
        display: flex; /* For icon alignment */
        align-items: center;
        gap: 8px;
    }
    .form-label i {
        font-size: 1.1rem;
        color: #17a2b8; /* Teal-like color for label icons */
    }

    /* Form Controls (input, textarea, select) */
    .form-control, .form-select {
        border-radius: 10px; /* Consistent rounded corners */
        padding: 12px 15px; /* Good padding */
        border: 1px solid #e0e6ed; /* Light, soft border */
        background-color: #f8fbfd; /* Very light background */
        transition: all 0.3s ease;
        font-size: 1rem;
        color: #343a40;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        background-color: #ffffff;
    }
    .form-control::placeholder {
        color: #8696a8;
        opacity: 0.9;
    }

    /* Submit Button */
    .btn-submit-lead {
        font-weight: 700;
        border-radius: 30px; /* Pill-shaped */
        padding: 12px 30px;
        transition: all 0.4s ease;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        color: white;
        background: linear-gradient(145deg, #4dc0ff 0%, #00aaff 100%); /* Lighter, more vibrant blues */
        border: none;
    }
    .btn-submit-lead:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        background: linear-gradient(145deg, #00aaff 0%, #4dc0ff 100%);
    }
    .btn-submit-lead i {
        margin-left: 8px;
        font-size: 1.2rem;
    }

    /* Alert Messages */
    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }
    .alert ul {
        margin-bottom: 0;
        padding-right: 20px; /* Indent list for RTL */
    }
    .alert .btn-close {
        float: left; /* Adjust close button for RTL */
        margin-right: -0.75rem;
        margin-left: 0;
    }

    /* Validation Feedback */
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        display: block; /* Ensure it's always block for proper spacing */
        font-size: 0.875rem;
        color: #dc3545;
        margin-top: 0.25rem;
        text-align: right;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) { /* Tablets */
        .page-wrapper-lead-create {
            padding: 20px;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .lead-form-card {
            padding: 25px;
        }
        .page-title-lead-create {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .page-title-lead-create i {
            font-size: 2.2rem;
        }
        .form-control, .form-select {
            padding: 10px 12px;
            font-size: 0.95rem;
        }
        .btn-submit-lead {
            padding: 10px 25px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 767px) { /* Small tablets / Mobile */
        .page-wrapper-lead-create {
            padding: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
        }
        .lead-form-card {
            padding: 20px;
            border-radius: 15px;
        }
        .page-title-lead-create {
            font-size: 1.8rem;
            margin-bottom: 20px;
            gap: 10px;
        }
        .page-title-lead-create i {
            font-size: 2rem;
        }
        .form-label {
            font-size: 0.95rem;
            gap: 5px;
        }
        .form-label i {
            font-size: 1rem;
        }
        .form-control, .form-select {
            padding: 8px 10px;
            font-size: 0.9rem;
        }
        .btn-submit-lead {
            width: 100%; /* Full width button on mobile */
            padding: 10px 20px;
            font-size: 1rem;
        }
        .alert {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) { /* Very small mobile */
        .page-wrapper-lead-create {
            padding: 10px;
        }
        .lead-form-card {
            padding: 15px;
        }
        .page-title-lead-create {
            font-size: 1.6rem;
            margin-bottom: 15px;
        }
        .page-title-lead-create i {
            font-size: 1.8rem;
        }
        .form-label {
            font-size: 0.9rem;
        }
        .form-control, .form-select {
            font-size: 0.85rem;
        }
    }
</style>

<div class="page-wrapper-lead-create">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h3 class="page-title-lead-create">
                    <i class="bi bi-lightbulb-fill"></i>ثبت سرنخ جدید
                </h3>

                {{-- Success and Error Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card lead-form-card">
                    <div class="card-body">
                        <form action="{{ route('leads.store') }}" method="POST" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label"><i class="bi bi-person-fill"></i>نام <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="نام مشتری احتمالی">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label"><i class="bi bi-phone-fill"></i>تلفن <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="شماره تماس مشتری احتمالی">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label"><i class="bi bi-building-fill"></i>شرکت</label>
                                <input type="text" name="company" id="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}" placeholder="نام شرکت مشتری احتمالی">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="source" class="form-label"><i class="bi bi-person-badge-fill"></i>منبع آشنایی</label>
                                <input type="text" name="source" id="source" class="form-control @error('source') is-invalid @enderror" value="{{ old('source') }}" placeholder="نحوه آشنایی با مشتری">
                                @error('source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="interest_level" class="form-label"><i class="bi bi-star-fill"></i>سطح علاقه‌مندی</label>
                                <select name="interest_level" id="interest_level" class="form-select @error('interest_level') is-invalid @enderror">
                                    <option value="کم" {{ old('interest_level') == 'کم' ? 'selected' : '' }}>کم</option>
                                    <option value="متوسط" {{ old('interest_level', 'متوسط') == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                                    <option value="زیاد" {{ old('interest_level') == 'زیاد' ? 'selected' : '' }}>زیاد</option>
                                </select>
                                @error('interest_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label"><i class="bi bi-bar-chart-fill"></i>وضعیت</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="در انتظار تماس" {{ old('status') == 'در انتظار تماس' ? 'selected' : '' }}>در انتظار تماس</option>
                                    <option value="تماس گرفته شد" {{ old('status') == 'تماس گرفته شد' ? 'selected' : '' }}>تماس گرفته شد</option>
                                    <option value="تبدیل به مشتری شد" {{ old('status') == 'تبدیل به مشتری شد' ? 'selected' : '' }}>تبدیل به مشتری شد</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label"><i class="bi bi-journal-text"></i>یادداشت</label>
                                <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror" rows="3" placeholder="توضیحات اضافی درباره سرنخ">{{ old('note') }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-submit-lead">
                                    <i class="bi bi-save-fill"></i> ذخیره سرنخ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection