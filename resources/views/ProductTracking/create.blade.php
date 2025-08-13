@extends('layouts.app')
@section('title', 'ثبت رهگیری محصول')

@push('styles')
<style>
    /*
    ===================================================
    استایل‌های اختصاصی این صفحه
    ===================================================
    */

    /* رنگ‌ها را از قالب اصلی دریافت می‌کنیم */
    .card {
        border-radius: 0.75rem; /* گوشه‌های گردتر */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: white; /* رنگ پس‌زمینه کارت */
    }
    
    .card:hover {
        transform: translateY(-4px); /* کمی به بالا حرکت می‌کند */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .card-header {
        background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
        color: var(--text-light);
        border-radius: 0.75rem 0.75rem 0 0 !important;
        padding: 1.5rem;
        border-bottom: none;
    }
    
    .card-header h3 {
        color: white !important; /* متن تیتر حتما سفید باشد */
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    .form-control, .form-select {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0; /* رنگ border روشن‌تر */
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    
    .form-label {
        font-weight: 500;
        color: #4a5568;
    }
    
    .btn-primary {
        background-color: var(--accent-color);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    
    .status-icon {
        font-size: 1.2rem;
        margin-left: 0.5rem;
    }
    
    .alert {
        border-radius: 0.5rem;
        border-color: transparent;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-text {
        font-size: 0.85rem;
        color: var(--text-muted);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="m-0">
                        <i class="fas fa-clipboard-check status-icon"></i>
                        ثبت وضعیت جدید برای محصول
                    </h3>
                </div>
                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('tracking.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="product_code" class="form-label fw-bold">
                                <i class="fas fa-barcode status-icon"></i>
                                کد محصول
                            </label>
                            <input type="text" name="product_code" id="product_code" class="form-control form-control-lg" required>
                            <div class="form-text">کد منحصر به فرد محصول را وارد نمایید</div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-bold">
                                <i class="fas fa-tasks status-icon"></i>
                                وضعیت محصول
                            </label>
                            <select name="status" id="status" class="form-select form-select-lg" required>
                                <option value="">-- انتخاب وضعیت --</option>
                                <option value="انبار">انبار</option>
                                <option value="درحال ارسال">درحال ارسال</option>
                                <option value="ارسال شد">ارسال شد</option>
                                <option value="درحال تولید">درحال تولید</option>
                                <option value="آماده سازی">آماده سازی</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="note" class="form-label fw-bold">
                                <i class="fas fa-comment-dots status-icon"></i>
                                توضیحات
                            </label>
                            <textarea name="note" id="note" class="form-control" rows="4"></textarea>
                            <div class="form-text">توضیحات اختیاری درباره وضعیت محصول</div>
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                ثبت وضعیت
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection