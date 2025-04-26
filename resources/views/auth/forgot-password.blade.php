<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>بازیابی رمز عبور</title>
    
    <!-- بوت‌استرپ 5 RTL -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css'>
    
    <!-- فونت آوسام -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    
    <!-- استایل های سفارشی -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card {
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-md-6 col-lg-5'>
                <div class='card shadow border-0 rounded-4 mt-5'>
                    <div class='card-header text-center bg-primary text-white py-3 rounded-top-4 border-0'>
                        <h4 class='mb-0'><i class='fas fa-key me-2'></i>بازیابی رمز عبور</h4>
                    </div>
                    <div class='card-body p-4'>
                        @if (session('status'))
                            <div class='alert alert-success alert-dismissible fade show mb-4' role='alert'>
                                <i class='fas fa-check-circle me-2'></i>{{ session('status') }}
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>
                        @endif
                        <form method='POST' action='{{ route('password.email') }}'>
                            @csrf
                            <p class='text-muted text-center mb-4'>
                                لطفاً ایمیل حساب کاربری خود را وارد کنید تا لینک بازیابی رمز عبور برای شما ارسال شود.
                            </p>
                            <div class='mb-4'>
                                <div class='form-floating'>
                                    <input type='email' name='email' id='email' class='form-control @error('email') is-invalid @enderror' placeholder='ایمیل خود را وارد کنید' value='{{ old('email') }}' required autofocus>
                                    <label for='email'>
                                        <i class='fas fa-envelope text-muted me-1'></i>
                                        آدرس ایمیل
                                    </label>
                                    @error('email')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class='d-grid mb-3'>
                                <button type='submit' class='btn btn-primary py-3 btn-lg position-relative overflow-hidden'>
                                    <span class='d-flex align-items-center justify-content-center'>
                                        <i class='fas fa-paper-plane me-2'></i>
                                        ارسال لینک بازیابی
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class='card-footer bg-light py-3 text-center border-0 rounded-bottom-4'>
                        <a href='{{ route('login') }}' class='text-decoration-none'>
                            <i class='fas fa-arrow-right me-1'></i>
                            بازگشت به صفحه ورود
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- جاوااسکریپت بوت‌استرپ -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
