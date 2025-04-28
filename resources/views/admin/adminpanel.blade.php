<!DOCTYPE html>
<html lang='fa'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>پنل مدیریت</title>

    <!-- اضافه کردن فونت وزیر -->
    <link href='https://cdn.jsdelivr.net/npm/@fontsource/vazir@4.0.0/dist/font.css' rel='stylesheet'>

    <!-- اضافه کردن استایل‌های Bootstrap 5 -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>

    <!-- افزودن استایل راستچین -->
    <style>
        body {
            font-family: 'Vazir', sans-serif;
        }
    </style>
</head>

<body>
    <div class='container-fluid'>
        <div class='row'>
            <!-- منوی کناری -->
            <div class='col-md-3 bg-light p-3'>
                <h4>پنل مدیریت</h4>
                <p>کاربر: {{ Auth::user()->name }}</p>
                <ul class='nav flex-column'>
                    <li class='nav-item'>
                        {{-- <a class='nav-link' href='{{ route('admin.dashboard') }}'>داشبورد</a> --}}
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='{{ route('complaints.admin.index') }}'>مدیریت شکایات</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='{{ route('admin.reports') }}'>گزارشات</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='{{ route('users.index') }}'>لیست کاربران</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='{{ route('users.create') }}'>ساخت اکانت کاربری</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link text-danger' href='{{ route('logout') }}' 
                           onclick='event.preventDefault(); document.getElementById('logout-form').submit();'>خروج</a>
                        <form id='logout-form' action='{{ route('logout') }}' method='POST' style='display: none;'>
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <!-- محتوای اصلی -->
            <div class='col-md-9 p-3'>
                @yield('content')
            </div>
        </div>
    </div>

    <!-- اضافه کردن JSهای Bootstrap 5 -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>

