<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جستجوی وضعیت محصول</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Vazir', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-color);
        }
        
        .search-card {
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            border: none;
            transition: all 0.3s;
            overflow: hidden;
        }
        
        .search-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.75rem 0 rgba(58, 59, 69, 0.2);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color) 100%);
            color: white;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .card-header:before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        
        .card-header.bg-info {
            background: linear-gradient(135deg, var(--info-color) 0%, var(--info-color) 100%);
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #d1d3e2;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            background-color: #17a673;
            transform: translateY(-2px);
        }
        
        .search-icon {
            font-size: 1.2rem;
            margin-left: 8px;
        }
        
        .result-item {
            border-radius: 8px !important;
            margin-bottom: 10px;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s;
        }
        
        .result-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .status-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .not-found {
            animation: shake 0.5s;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        .animated-wave {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" fill="%234e73df" opacity=".25"/><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" fill="%234e73df" opacity=".5"/><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%234e73df"/></svg>');
            background-size: cover;
            background-repeat: no-repeat;
            z-index: -1;
            opacity: 0.1;
        }
        
        @media (max-width: 768px) {
            .card-header {
                padding: 1rem;
            }
            
            .search-card {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="animated-wave"></div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="search-card">
                    <div class="card-header">
                        <h4 class="m-0">
                            <i class="fas fa-search search-icon"></i>
                            جستجوی وضعیت محصول
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('product.tracking.search') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="product_code" class="form-label fw-bold">
                                    <i class="fas fa-barcode search-icon"></i>
                                    کد محصول
                                </label>
                                <input type="text" name="product_code" class="form-control form-control-lg" required placeholder="کد محصول را وارد نمایید...">
                                <div class="form-text mt-2">کد منحصر به فرد محصول را وارد کنید</div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-search me-2"></i>
                                    جستجو
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(isset($tracking))
                    <div class="search-card mt-4">
                        <div class="card-header bg-info">
                            <h4 class="m-0">
                                <i class="fas fa-clipboard-list search-icon"></i>
                                نتیجه جستجو
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item result-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">کد محصول:</span>
                                    <span class="badge bg-primary rounded-pill">{{ $tracking->product_code }}</span>
                                </li>
                                <li class="list-group-item result-item d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">وضعیت:</span>
                                    <span class="status-badge 
                                        @if($tracking->status == 'انبار') bg-secondary
                                        @elseif($tracking->status == 'درحال ارسال') bg-warning text-dark
                                        @elseif($tracking->status == 'ارسال شد') bg-success
                                        @elseif($tracking->status == 'درحال تولید') bg-info
                                        @elseif($tracking->status == 'آماده سازی') bg-primary
                                        @endif">
                                        {{ $tracking->status }}
                                    </span>
                                </li>
                                <li class="list-group-item result-item">
                                    <div class="fw-bold mb-2">توضیحات:</div>
                                    <div class="p-3 bg-light rounded">
                                        {{ $tracking->note ?? 'توضیحاتی ثبت نشده است' }}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                @elseif(isset($searched) && !$tracking))
                    <div class="alert alert-danger mt-4 not-found">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        محصولی با این کد یافت نشد!
                        <button type="button" class="btn-close float-start" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for not found alert
            const notFoundAlert = document.querySelector('.not-found');
            if (notFoundAlert) {
                setTimeout(() => {
                    notFoundAlert.classList.remove('not-found');
                }, 500);
            }
            
            // Auto focus on search input
            const searchInput = document.querySelector('input[name="product_code"]');
            if (searchInput) {
                searchInput.focus();
            }
        });
    </script>
</body>
</html>
