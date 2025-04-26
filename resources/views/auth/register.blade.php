<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>ثبت‌نام</title>
    
    <!-- لینک به فونت وزیر -->
    <link href='https://fonts.googleapis.com/css2?family=Vazir&display=swap' rel='stylesheet'>
    <!-- لینک به بوت استرپ -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    <!-- آیکون‌های فونت آوسام -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel='stylesheet'>
    
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #50e3c2;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --info-color: #2196f3;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --background-gradient: linear-gradient(135deg, #f0f4f8 0%, #d9e4f5 100%);
        }

        body {
            font-family: 'Vazir', sans-serif;
            background: var(--background-gradient);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            animation: fadeIn 0.8s ease;
        }

        .register-card {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }

        .register-card-header {
            background: linear-gradient(to left, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .register-card-body {
            padding: 30px;
        }

        .register-btn {
            background: linear-gradient(to left, var(--success-color), #66bb6a);
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            color: var(--dark-color);
        }

        .form-control {
            border-radius: 5px;
            height: 45px;
            padding: 10px 40px 10px 10px; /* فضای بیشتر برای آیکون toggle */
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 5;
        }

        .form-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-md-6 col-lg-4'>
                <div class='card register-card'>
                    <div class='card-header register-card-header'>
                        <h4>ثبت‌نام</h4>
                    </div>
                    <div class='card-body register-card-body'>
                        <form action='{{ route('register') }}' method='POST'>
                            @csrf
                            <div class='mb-3'>
                                <label for='name' class='form-label'>نام</label>
                                <input type='text' name='name' id='name' class='form-control' required>
                            </div>
                            <div class='mb-3'>
                                <label for='email' class='form-label'>ایمیل</label>
                                <input type='email' name='email' id='email' class='form-control' required>
                            </div>
                            <div class='mb-3'>
                                <label for='password' class='form-label'>رمز عبور</label>
                                <div class='password-input-group'>
                                    <input type='password' name='password' id='password' class='form-control' required>
                                    <i class='fas fa-eye password-toggle' id='togglePassword'></i>
                                </div>
                                <small class='form-text text-muted'>حداقل ۸ کاراکتر، شامل حروف بزرگ، کوچک و اعداد.</small>
                            </div>
                            <div class='mb-3'>
                                <label for='password_confirmation' class='form-label'>تکرار رمز عبور</label>
                                <div class='password-input-group'>
                                    <input type='password' name='password_confirmation' id='password_confirmation' class='form-control' required>
                                    <i class='fas fa-eye password-toggle' id='togglePasswordConfirmation'></i>
                                </div>
                            </div>
                            <button type='submit' class='btn register-btn'>ثبت‌نام</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- اسکریپت‌های جاوا اسکریپت -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
    <script>
        // نمایش/مخفی کردن رمز عبور
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // نمایش/مخفی کردن تکرار رمز عبور
        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
