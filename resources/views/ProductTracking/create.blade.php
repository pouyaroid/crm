@extends('layouts.app')
@section('title','ثبت رهگیری محصول')
@section('content')

    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --accent-color: #2e59d9;
            --text-color: #5a5c69;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Vazir', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
        }
        
        .card {
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.75rem 0 rgba(58, 59, 69, 0.3);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #d1d3e2;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }
        
        .status-icon {
            font-size: 1.2rem;
            margin-left: 8px;
        }
        
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            opacity: 0.7;
        }
        
        @media (max-width: 768px) {
            .card {
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
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
                                    <option value="انبار">
                                        <i class="fas fa-warehouse"></i> انبار
                                    </option>
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Persian Data for Bootstrap -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set RTL for Bootstrap components
            if (typeof bootstrap !== 'undefined') {
                // Tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        placement: 'left'
                    })
                });
                
                // Popovers
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl, {
                        placement: 'left'
                    })
                });
            }
        });
    </script>
</body>
</html>
@endsection