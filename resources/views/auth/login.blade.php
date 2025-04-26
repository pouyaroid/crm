<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>ورود به حساب</title>
    <link href='https://fonts.googleapis.com/css2?family=Vazir:wght@400;500;700&display=swap' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css'>
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4ecf7 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            transition: transform 0.3s ease;
        }
        .login-card:hover {
            transform: translateY(-5px);
        }
        .login-card-header {
            background: linear-gradient(135deg, #0062cc 0%, #0096ff 100%);
            color: white;
            padding: 25px;
            text-align: center;
            border-bottom: none;
        }
        .login-card-header h4 {
            font-weight: 700;
            margin: 0;
            font-size: 1.5rem;
        }
        .login-card-body {
            padding: 35px;
            background: white;
        }
        .login-btn {
            background: linear-gradient(135deg, #0f4e1d 0%, #176227 100%);
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(15, 78, 29, 0.2);
        }
        .login-btn:hover {
            background: linear-gradient(135deg, #176227 0%, #1f7a32 100%);
            box-shadow: 0 6px 12px rgba(15, 78, 29, 0.25);
            transform: translateY(-2px);
        }
        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        .form-control {
            border-radius: 8px;
            height: 50px;
            padding: 12px 15px;
            border: 1px solid #e1e5eb;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #0096ff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        }
        .form-check-input {
            width: 18px;
            height: 18px;
            margin-left: 8px;
        }
        .form-check-label {
            padding-right: 5px;
            color: #555;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            color: #6c757d;
        }
        .password-toggle {
            cursor: pointer;
        }
        .form-icon {
            display: flex;
            align-items: center;
        }
        .form-icon i {
            margin-left: 10px;
            color: #6c757d;
        }
        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .form-footer a {
            color: #0096ff;
            text-decoration: none;
            transition: color 0.2s;
        }
        .form-footer a:hover {
            color: #0062cc;
            text-decoration: underline;
        }
        .invalid-feedback {
            font-size: 0.85rem;
            color: #dc3545;
        }
        .login-card-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-card-logo img {
            height: 60px;
        }
        .remember-me {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
<div class='container'>
    <div class='row justify-content-center'>
        <div class='col-12 col-md-8 col-lg-5'>
            <div class='card login-card'>
                <div class='card-header login-card-header'>
                    <h4>ورود به سیستم</h4>
                    <p class='mb-0 mt-2 text-white-50'>لطفاً اطلاعات خود را وارد کنید</p>
                </div>
                <div class='card-body login-card-body'>
                    <div class='login-card-logo'>
                        <!-- شما می‌توانید لوگوی خود را اینجا قرار دهید -->
                        <i class='bi bi-person-circle' style='font-size: 3rem; color: #0096ff;'></i>
                    </div>

                    {{-- نمایش ارورهای احراز هویت --}}
                    @if (session('status'))
                        <div class='alert alert-danger alert-dismissible fade show text-center' role='alert'>
                            <i class='bi bi-exclamation-triangle-fill me-2'></i>
                            {{ session('status') }}
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    @endif

                    <form action='{{ route('login') }}' method='POST'>
                        @csrf
                        <div class='mb-4'>
                            <label for='email' class='form-label'>
                                <span class='form-icon'><i class='bi bi-envelope'></i> ایمیل</span>
                            </label>
                            <input type='email' name='email' id='email' 
                                class='form-control @error('email') is-invalid @enderror' 
                                placeholder='example@domain.com' 
                                required autofocus value='{{ old('email') }}'>
                            @error('email')
                                <div class='invalid-feedback'>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class='mb-4'>
                            <label for='password' class='form-label'>
                                <span class='form-icon'><i class='bi bi-lock'></i> رمز عبور</span>
                            </label>
                            <div class='input-group'>
                                <input type='password' name='password' id='password' 
                                    class='form-control @error('password') is-invalid @enderror' 
                                    required>
                                <span class='input-group-text password-toggle' onclick='togglePassword()'>
                                    <i class='bi bi-eye' id='toggleIcon'></i>
                                </span>
                                @error('password')
                                    <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class='mb-4 remember-me'>
                            <div class='form-check'>
                                <input type='checkbox' name='remember' id='remember' 
                                    class='form-check-input' {{ old('remember') ? 'checked' : '' }}>
                                <label for='remember' class='form-check-label'>مرا به خاطر بسپار</label>
                            </div>
                        </div>
                        <button type='submit' class='btn login-btn'>
                            <i class='bi bi-box-arrow-in-right ml-2'></i> ورود به حساب
                        </button>
                    </form>

                    <div class='form-footer'>
                        <div>
                            <a href='{{ route('password.request') }}'>فراموشی رمز عبور؟</a>
                        </div>
                        <div>
                            حساب ندارید؟ <a href='{{ route('register') }}'>ثبت نام</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }
</script>
</body>
</html>
