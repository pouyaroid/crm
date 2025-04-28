<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>ساخت کاربر جدید</title>
    
    <!-- Bootstrap 5 RTL CSS از CDN -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    
    <!-- فونت فارسی Vazir از Google Fonts -->
    <link href='https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;700&display=swap' rel='stylesheet'>
    
    <!-- CSS سفارشی برای تنظیم فونت -->
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background-color: #f8f9fa; /* رنگ زمینه نرم برای زیبایی */
        }
        .form-container {
            max-width: 500px; /* عرض حداکثری برای تمرکز فرم */
            margin: 50px auto; /* مرکزسازی و فاصله از بالا */
            padding: 20px;
            border-radius: 10px; /* گوشه‌های گرد برای زیبایی */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* سایه برای عمق */
            background-color: #ffffff; /* زمینه سفید برای کنتراست */
        }
        .form-label {
            font-weight: 600; /* وزن فونت برای برجسته‌سازی لیبل‌ها */
            color: #333; /* رنگ تیره برای خوانایی بهتر */
        }
        .btn-primary {
            background-color: #007bff; /* رنگ آبی اصلی بوت‌استرپ */
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* تغییر رنگ در هورور برای انیمیشن ساده */
            border-color: #0056b3;
        }
        .invalid-feedback {
            font-size: 0.875em; /* اندازه فونت کوچک‌تر برای فیدبک خطاها */
            color: #dc3545; /* رنگ قرمز برای خطاها */
        }
    </style>
</head>
<body>

    <div class='container'>
        <div class='form-container'>
            <h1 class='text-center mb-4'>ساخت کاربر جدید با نقش</h1> <!-- عنوان مرکزی و فاصله از فرم -->

            <form action='{{ route('users.store') }}' method='POST' class='needs-validation' novalidate>
                @csrf
                
                <!-- فیلد نام -->
                <div class='mb-3'>
                    <label for='name' class='form-label'>نام:</label>
                    <input type='text' name='name' id='name' class='form-control @error('name') is-invalid @enderror' required>
                    @error('name')
                        <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- فیلد ایمیل -->
                <div class='mb-3'>
                    <label for='email' class='form-label'>ایمیل:</label>
                    <input type='email' name='email' id='email' class='form-control @error('email') is-invalid @enderror' required>
                    @error('email')
                        <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- فیلد رمز عبور -->
                <div class='mb-3'>
                    <label for='password' class='form-label'>رمز عبور:</label>
                    <input type='password' name='password' id='password' class='form-control @error('password') is-invalid @enderror' required>
                    @error('password')
                        <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- فیلد نقش -->
                <div class='mb-4'>
                    <label for='role' class='form-label'>نقش:</label>
                    <select name='role' id='role' class='form-select @error('role') is-invalid @enderror' required>
                        @foreach($roles as $role)
                            <option value='{{ $role->name }}'>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- دکمه submit -->
                <button type='submit' class='btn btn-primary w-100'>ایجاد کاربر</button> <!-- عرض کامل برای زیبایی -->
            </form>
        </div>
    </div>

    <!-- اسکریپت‌های Bootstrap اگر لازم باشد، اما برای این فرم ساده ضروری نیست -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    
    <!-- اسکریپت ساده برای اعتبارسنجی سمت کلاینت -->
    <script>
        // فعال‌سازی اعتبارسنجی HTML5
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>
