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

    <!-- افزودن استایل راست‌چین و استایل‌های سفارشی -->
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            width: 250px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #343a40;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: #f1f1f1;
            color: #007bff;
        }
        .sidebar .nav-link.text-danger {
            color: #dc3545;
        }
        .content {
            margin-right: 260px;
            padding: 20px;
        }
        .nav-item + .nav-item {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class='sidebar'>
        <h4 class='text-center'>پنل مدیریت</h4>
        <p class='text-center'>کاربر: {{ Auth::user()->name }}</p>
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
    <div class='content'>
        @yield('content')
    </div>

    <!-- اضافه کردن JSهای Bootstrap 5 -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>
