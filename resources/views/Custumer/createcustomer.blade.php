@extends('layouts.app')

@section('title', 'ثبت اطلاعات مشتری جدید')

@section('content')
{{-- Links to Bootstrap RTL CSS and Bootstrap Icons --}}
{{-- It's generally better to include these in your main layout (layouts/app.blade.php) --}}
{{-- to avoid repetition and ensure consistency across your application. --}}
{{-- For this example, I'm keeping them here as per your original code structure. --}}
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
{{-- Vazirmatn Font for enhanced Persian typography --}}
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet">

<style>
    /* Base styles for the body and font */
    body {
        font-family: 'Vazirmatn', sans-serif; /* Using Vazirmatn for better Persian display */
        background-color: #f0f4f8; /* Softer background color */
        margin: 0;
        padding: 0;
        direction: rtl; /* Ensure RTL direction */
        text-align: right; /* Ensure text alignment for RTL */
    }

    /* Styles for the main form container */
    .form-container {
        background: linear-gradient(180deg, #ffffff, #fdfdfd); /* Subtle gradient background */
        border-radius: 18px; /* More rounded corners */
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15); /* Deeper, softer shadow */
        padding: 2.5rem 3.5rem; /* Increased padding */
        margin-top: 3.5rem; /* Increased top margin */
        margin-bottom: 3.5rem; /* Add bottom margin for spacing */
        border: 1px solid rgba(255, 255, 255, 0.8); /* Light border for subtle depth */
        backdrop-filter: blur(5px); /* Optional: slight blur effect for modern look */
    }

    /* Styles for section titles within the form */
    .form-section-title {
        font-size: 1.5rem; /* Slightly larger font size */
        font-weight: 600; /* Bolder font weight */
        margin-bottom: 1.5rem; /* Increased bottom margin */
        display: flex;
        align-items: center;
        /* Dynamic gradient border for a modern look */
        border-bottom: 3px solid transparent;
        border-image: linear-gradient(to right, #007bff, #17a2b8) 1;
        padding-bottom: 0.75rem; /* Increased padding below border */
        color: #0056b3; /* Darker blue for text */
    }

    .form-section-title i {
        margin-left: 12px; /* Increased margin for icon */
        color: #007bff; /* Primary blue for icon */
        font-size: 1.6rem; /* Larger icon size */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle icon shadow */
    }

    /* Styles for form labels */
    .form-label {
        margin-bottom: 0.6rem; /* Slightly increased bottom margin */
        margin-top: 1.2rem; /* Increased top margin */
        font-weight: 600; /* Bolder label font */
        color: #343a40; /* Darker text color */
        display: block; /* Ensure label takes full width */
    }

    .form-label i {
        margin-left: 10px; /* Increased margin for icon */
        color: #1a8e9f; /* Teal-like color for label icons */
        font-size: 1.2rem; /* Slightly larger icon size */
    }

    /* Styles for form control inputs */
    .form-control {
        border-radius: 0.75rem; /* More rounded corners */
        border: 1px solid #cce0f0; /* Lighter, softer border */
        font-size: 1rem; /* Standard font size */
        padding: 0.75rem 1rem; /* More padding for better touch targets */
        transition: all 0.4s ease-in-out; /* Smoother transition */
        background-color: #fcfdff; /* Very light background */
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); /* Subtle inner shadow */
    }

    .form-control:focus {
        border-color: #007bff; /* Primary blue on focus */
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25), inset 0 1px 3px rgba(0, 0, 0, 0.08); /* Enhanced focus shadow */
        background-color: #ffffff; /* White background on focus */
    }

    .form-control::placeholder {
        font-size: 0.95rem; /* Slightly larger placeholder font */
        color: #8696a8; /* Softer placeholder color */
        opacity: 0.9;
    }

    /* Styles for primary button */
    .btn-primary {
        border-radius: 30px; /* Even more rounded, pill-shaped */
        background: linear-gradient(145deg, #007bff 0%, #00c6ff 100%); /* Vibrant blue gradient */
        border: none;
        padding: 0.8rem 3rem; /* More padding for a larger button */
        font-size: 1.1rem; /* Larger font size */
        font-weight: 700; /* Bolder text */
        transition: all 0.4s ease; /* Smoother transition */
        box-shadow: 0 8px 15px rgba(0, 123, 255, 0.3); /* Prominent button shadow */
    }

    .btn-primary:hover {
        background: linear-gradient(145deg, #00c6ff 0%, #007bff 100%); /* Reverse gradient on hover */
        transform: translateY(-3px) scale(1.02); /* Slight lift and scale on hover */
        box-shadow: 0 12px 20px rgba(0, 123, 255, 0.4); /* Enhanced shadow on hover */
    }

    .btn-primary i {
        font-size: 1.2rem; /* Larger icon in button */
        color: #fff;
        margin-left: 8px; /* Increased margin for icon */
    }

    /* Styles for validation feedback (error messages) */
    .invalid-feedback {
        display: block; /* Ensure it's always block for proper spacing */
        font-size: 0.875rem;
        color: #dc3545; /* Standard danger color */
        margin-top: 0.25rem;
        text-align: right; /* Ensure RTL alignment */
    }

    /* Alert styles */
    .alert {
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        font-size: 1rem;
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
    .alert .btn-close {
        float: left; /* Adjust close button for RTL */
        margin-right: -0.75rem;
        margin-left: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-container {
            padding: 1.5rem 1.5rem; /* Adjust padding for smaller screens */
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        .form-section-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        .form-section-title i {
            font-size: 1.4rem;
        }
        .form-label {
            margin-top: 0.8rem;
        }
        .btn-primary {
            padding: 0.7rem 2.5rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .form-container {
            padding: 1rem 1rem;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-section-title {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
        }
        .form-section-title i {
            font-size: 1.3rem;
        }
        .form-label {
            margin-top: 0.6rem;
        }
        .btn-primary {
            width: 100%; /* Full width button on extra small screens */
            padding: 0.6rem 2rem;
            font-size: 0.95rem;
        }
    }
</style>

<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-lg-10 col-xl-8'>
            <div class='form-container'>
                <h2 class='text-center fw-bold mb-5'>
                    <i class='bi bi-person-lines-fill' style='color: #007bff;'></i>ثبت اطلاعات مشتری جدید
                </h2>

                {{-- Success and Error Alerts --}}
                @if(session('success'))
                    <div class='alert alert-success alert-dismissible fade show text-center' role='alert'>
                        {{ session('success') }}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class='alert alert-danger alert-dismissible fade show text-center' role='alert'>
                        {{ session('error') }}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                @endif

                <form action='{{ route('customers.store') }}' method='POST' novalidate>
                    @csrf

                    <div class='form-section-title'>
                        <i class='bi bi-building'></i>اطلاعات شرکت
                    </div>
                    <div class='row g-3 mb-4'> {{-- Added mb-4 for spacing --}}
                        <div class='col-md-6'>
                            <label class='form-label' for='company_name'>
                                <i class='bi bi-card-text'></i>نام شرکت <span class="text-danger">*</span>
                            </label>
                            <input type='text' class='form-control @error('company_name') is-invalid @enderror' id='company_name' name='company_name' placeholder='مثال: شرکت پویش' value="{{ old('company_name') }}" required>
                            @error('company_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label' for='company_type'>
                                <i class='bi bi-diagram-3'></i>نوع شرکت <span class="text-danger">*</span>
                            </label>
                            <input type='text' class='form-control @error('company_type') is-invalid @enderror' id='company_type' name='company_type' placeholder='مثال: خصوصی' value="{{ old('company_type') }}" required>
                            @error('company_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class='form-section-title mt-4'>
                        <i class='bi bi-telephone'></i>اطلاعات تماس
                    </div>
                    <div class='row g-3 mb-4'> {{-- Added mb-4 for spacing --}}
                        <div class='col-md-6'>
                            <label class='form-label' for='personal_name'>
                                <i class='bi bi-person-circle'></i>نام شخص تماس <span class="text-danger">*</span>
                            </label>
                            <input type='text' class='form-control @error('personal_name') is-invalid @enderror' id='personal_name' name='personal_name' placeholder='مثال: علی احمدی' value="{{ old('personal_name') }}" required>
                            @error('personal_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label class='form-label' for='email'>
                                <i class='bi bi-envelope'></i>ایمیل <span class="text-danger">*</span>
                            </label>
                            <input type='email' class='form-control @error('email') is-invalid @enderror' id='email' name='email' placeholder='info@example.com' value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label' for='company_phone'>
                                <i class='bi bi-telephone-inbound'></i>تلفن شرکت
                            </label>
                            <input type='text' class='form-control @error('company_phone') is-invalid @enderror' id='company_phone' name='company_phone' placeholder='مثال: 02112345678' value="{{ old('company_phone') }}">
                            @error('company_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label class='form-label' for='mobile_phone'>
                                <i class='bi bi-phone'></i>تلفن همراه
                            </label>
                            <input type='text' class='form-control @error('mobile_phone') is-invalid @enderror' id='mobile_phone' name='mobile_phone' placeholder='مثال: 09121234567' value="{{ old('mobile_phone') }}">
                            @error('mobile_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class='form-section-title mt-4'>
                        <i class='bi bi-info-circle'></i>اطلاعات اضافی
                    </div>
                    <div class='row g-3 mb-4'> {{-- Added mb-4 for spacing --}}
                        <div class='col-md-6'>
                            <label class='form-label' for='ceo'>
                                <i class='bi bi-person-badge'></i>مدیر عامل
                            </label>
                            <input type='text' class='form-control @error('ceo') is-invalid @enderror' id='ceo' name='ceo' placeholder='مثال: محمد رضایی' value="{{ old('ceo') }}">
                            @error('ceo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label class='form-label' for='address'>
                                <i class='bi bi-geo-alt'></i>آدرس
                            </label>
                            <input type='text' class='form-control @error('address') is-invalid @enderror' id='address' name='address' placeholder='مثال: تهران، خیابان مثال' value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label class='form-label' for='bank'>
                                <i class='bi bi-bank'></i>بانک
                            </label>
                            <input type='text' class='form-control @error('bank') is-invalid @enderror' id='bank' name='bank' placeholder='مثال: بانک ملت' value="{{ old('bank') }}">
                            @error('bank')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='col-md-6'>
                            <label class='form-label' for='account_number'>
                                <i class='bi bi-hash'></i>شماره حساب
                            </label>
                            <input type='text' class='form-control @error('account_number') is-invalid @enderror' id='account_number' name='account_number' placeholder='مثال: 1234567890' value="{{ old('account_number') }}">
                            @error('account_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label class='form-label' for='postal_code'>
                                <i class='bi bi-mailbox'></i>کد پستی
                            </label>
                            <input type='text' class='form-control @error('postal_code') is-invalid @enderror' id='postal_code' name='postal_code' placeholder='مثال: 1234567890' value="{{ old('postal_code') }}">
                            @error('postal_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label class='form-label' for='id_meli'>
                                <i class='bi bi-person-vcard'></i>کد ملی
                            </label>
                            <input type='text' class='form-control @error('id_meli') is-invalid @enderror' id='id_meli' name='id_meli' placeholder='مثال: 1234567890' value="{{ old('id_meli') }}">
                            @error('id_meli')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label class='form-label' for='code_eghtesadi'>
                                <i class='bi bi-cash-stack'></i>کد اقتصادی
                            </label>
                            <input type='text' class='form-control @error('code_eghtesadi') is-invalid @enderror' id='code_eghtesadi' name='code_eghtesadi' placeholder='مثال: 123456789012' value="{{ old('code_eghtesadi') }}">
                            @error('code_eghtesadi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class='mt-4'>
                        <label class='form-label' for='note'>
                            <i class='bi bi-journal-text'></i>یادداشت
                        </label>
                        <textarea class='form-control @error('note') is-invalid @enderror' id='note' name='note' rows='4' placeholder='توضیحات اضافی را وارد کنید...'>{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class='text-center mt-5'> {{-- Increased top margin for button --}}
                        <button type='submit' class='btn btn-primary px-5 py-2 fw-bold'>
                            <i class='bi bi-check-circle'></i>ثبت اطلاعات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap Bundle with Popper for alerts and other JS components --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@endsection

