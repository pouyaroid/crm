
<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <title>@yield('title', 'پنل مدیریت')</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <!-- Bootstrap + Icons -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>

    <!-- فونت جذاب -->
    <link href='https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn-font/dist/font-face.css' rel='stylesheet'>

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f1f3f5;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .container-wrapper {
            display: flex;
            flex-wrap: nowrap;
            min-height: 100vh;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #212529, #343a40);
            color: #fff;
            width: 250px;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 1050;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1.2rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease-in-out;
        }
        .sidebar .nav-link i {
            margin-left: 0.75rem;
            font-size: 1.1rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #495057;
            color: #fff;
        }
        .sidebar h4 {
            font-size: 1.3rem;
            font-weight: bold;
            padding: 1rem;
            border-bottom: 1px solid #495057;
        }
        .content-wrapper {
            margin-right: 250px;
            padding: 20px;
            width: 100%;
            transition: margin-right 0.3s ease-in-out;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .content-wrapper {
                margin-right: 0;
            }
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 1040;
                display: none;
            }
            .overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>

<!-- Container Wrapper -->
<div class='container-wrapper'>
    <!-- Sidebar -->
    <div class='sidebar d-md-block' id='sidebar'>
        <h4 class='text-center'>🚀 CRM رشد</h4>
        <ul class='nav flex-column'>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('complaints.admin.index') ? 'active' : '' }}' href='{{ route('complaints.admin.index') }}'>
                    <i class='bi bi-house-door-fill'></i> لیست شکایات
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}' href='{{ route('admin.reports') }}'>
                    <i class='bi bi-bar-chart-line-fill'></i> گزارشات شکایت مشتری
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}' href='{{ route('users.create') }}'>
                    <i class='bi bi-person-plus-fill'></i> ساخت کاربر
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}' href='{{ route('users.index') }}'>
                    <i class='bi bi-person-lines-fill'></i> مشاهده کاربران
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('customers.create') ? 'active' : '' }}' href='{{ route('customers.create') }}'>
                    <i class='bi bi-person-plus'></i> ثبت مشتری
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}' href='{{ route('customers.index') }}'>
                    <i class='bi bi-people-fill'></i> لیست مشتریان
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('tracking.create.form') ? 'active' : '' }}' href='{{ route('tracking.create.form') }}'>
                    <i class='bi bi-box-arrow-in-down'></i> ثبت رهگیری محصولات
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('tracking.index') ? 'active' : '' }}' href='{{ route('tracking.index') }}'>
                    <i class='bi bi-box-arrow-in-up'></i> مشاهده رهگیری محصولات
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('leads.create') ? 'active' : '' }}' href='{{ route('leads.create') }}'>
                    <i class='bi bi-lightbulb'></i> ایجاد سرنخ جدید
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('leads.index') ? 'active' : '' }}' href='{{ route('leads.index') }}'>
                    <i class='bi bi-search'></i> مشاهده سرنخ‌ها
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link {{ request()->routeIs('leads.report') ? 'active' : '' }}' href='{{ route('leads.report') }}'>
                    <i class='bi bi-clipboard-data'></i> گزارش سرنخ‌ها
                </a>
            </li>
            <li class='nav-item mt-3'>
                <a class='nav-link' href='#'>
                    <i class='bi bi-gear-fill'></i> تنظیمات
                </a>
            </li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class='overlay d-md-none' id='overlay' onclick='toggleSidebar()'></div>

    <!-- Main Content -->
    <div class='content-wrapper'>
        <!-- Toggle Button -->
        <button class='btn btn-outline-dark d-md-none mb-3' onclick='toggleSidebar()'>
            <i class='bi bi-list'></i> منو
        </button>

        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
</script>

</body>
</html>
