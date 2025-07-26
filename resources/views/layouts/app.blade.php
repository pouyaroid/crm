<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'پنل مدیریت')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap RTL + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn-font/dist/font-face.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container-wrapper {
            display: flex;
            min-height: 100vh;
            background: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #1f2937, #4b5563);
            color: #e0e7ff;
            padding-top: 1.5rem;
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.25);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: right 0.3s ease;
        }

        .sidebar-header {
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            text-align: center;
            font-weight: 900;
            font-size: 1.6rem;
            color: #fbbf24;
            letter-spacing: 1.5px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.4);
            user-select: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* دکمه بستن منو در موبایل */
        .btn-close-menu {
            display: none;
            background: transparent;
            border: none;
            color: #fbbf24;
            font-size: 1.6rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .btn-close-menu:hover {
            color: #f59e0b;
        }

        .user-info {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-weight: 600;
            font-size: 1.1rem;
            color: #d1d5db;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255 255 255 / 0.05);
            user-select: none;
        }
        .user-info i {
            font-size: 1.4rem;
            color: #fbbf24;
        }

        /* Nav Links */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.75rem 1.75rem;
            font-weight: 500;
            color: #cbd5e1;
            border-right: 4px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .sidebar .nav-link i {
            font-size: 1.3rem;
            color: #9ca3af;
            transition: color 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(251, 191, 36, 0.15);
            border-right-color: #fbbf24;
            color: #fbbf24;
        }

        .sidebar .nav-link:hover i {
            color: #fbbf24;
        }

        .sidebar .nav-link.active {
            background-color: #fbbf24;
            color: #1f2937;
            font-weight: 700;
            border-right-color: #1f2937;
        }

        .sidebar .nav-link.active i {
            color: #1f2937;
        }

        .sidebar .nav-link:not(:last-child) {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Logout Button */
        .sidebar form button.nav-link {
            width: 100%;
            text-align: start;
            padding-left: 1.75rem;
            color: #ef4444;
            font-weight: 600;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .sidebar form button.nav-link:hover {
            background-color: rgba(239, 68, 68, 0.15);
            color: #b91c1c;
        }

        /* Content Wrapper */
        .content-wrapper {
            flex-grow: 1;
            margin-right: 280px;
            padding: 2rem 2.5rem;
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-right 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                right: -280px;
            }
            .sidebar.show {
                right: 0;
            }
            .content-wrapper {
                margin-right: 0;
                padding: 1rem 1.5rem;
            }
            .overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.45);
                z-index: 1040;
                transition: opacity 0.3s ease;
            }
            .overlay.show {
                display: block;
                opacity: 1;
            }

            /* نمایش دکمه بستن منو */
            .btn-close-menu {
                display: inline-block;
            }
        }

        /* Menu Toggle Button */
        .btn-toggle {
            background-color: #374151;
            color: #fbbf24;
            border: none;
            font-size: 1.2rem;
            padding: 0.5rem 1.2rem;
            border-radius: 0.375rem;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.3s ease;
            margin-bottom: 1rem;
        }
        .btn-toggle:hover {
            background-color: #4b5563;
        }
        .btn-toggle i {
            vertical-align: middle;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<div class="container-wrapper">
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar" aria-label="منوی اصلی">
        <div class="sidebar-header" tabindex="0">
            <div>
                <i class="bi bi-speedometer2"></i> CRM رشد
            </div>
            <!-- دکمه بستن منو فقط در موبایل -->
            <button class="btn-close-menu" id="closeMenuBtn" aria-label="بستن منو">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="user-info" aria-label="اطلاعات کاربر">
            <i class="bi bi-person-circle"></i>
            {{ auth()->user()->name ?? 'کاربر ناشناس' }}
        </div>

        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a href="{{ route('complaints.admin.index') }}" class="nav-link {{ request()->routeIs('complaints.admin.index') ? 'active' : '' }}">
                    <i class="bi bi-inbox-fill"></i> لیست شکایات
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i> گزارش شکایات
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.create') }}" class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus"></i> ساخت کاربر
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> کاربران
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customers.create') }}" class="nav-link {{ request()->routeIs('customers.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill"></i> ثبت مشتری
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> لیست مشتریان
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tracking.create.form') }}" class="nav-link {{ request()->routeIs('tracking.create.form') ? 'active' : '' }}">
                    <i class="bi bi-plus-square"></i> ثبت رهگیری
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tracking.index') }}" class="nav-link {{ request()->routeIs('tracking.index') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-up-right"></i> مشاهده رهگیری
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('leads.create') }}" class="nav-link {{ request()->routeIs('leads.create') ? 'active' : '' }}">
                    <i class="bi bi-lightbulb-fill"></i> سرنخ جدید
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('leads.index') }}" class="nav-link {{ request()->routeIs('leads.index') ? 'active' : '' }}">
                    <i class="bi bi-search-heart"></i> مشاهده سرنخ‌ها
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('leads.report') }}" class="nav-link {{ request()->routeIs('leads.report') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-data"></i> گزارش سرنخ‌ها
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('todos.index') }}" class="nav-link {{ request()->routeIs('todos.index') ? 'active' : '' }}">
                    <i class="bi bi-check2-square"></i> لیست وظایف
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('todos.create') }}" class="nav-link {{ request()->routeIs('todos.create') ? 'active' : '' }}">
                    <i class="bi bi-folder-plus"></i> ایجاد وظایف
                </a>
            </li>

            <li class="nav-item mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-start text-danger w-100">
                        <i class="bi bi-box-arrow-left"></i> خروج
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Overlay for small screens -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Main content -->
    <main class="content-wrapper">
        <button class="btn btn-toggle d-md-none" id="menuToggleBtn" aria-label="بازکردن منو">
            <i class="bi bi-list"></i> منو
        </button>
    
        {{-- نمایش نوتیفیکیشن‌های خوانده‌نشده --}}
        @if(auth()->check() && auth()->user()->unreadNotifications->count())
            <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                <div>
                    <i class="bi bi-bell-fill me-2"></i>
                    شما {{ auth()->user()->unreadNotifications->count() }} اعلان خوانده‌نشده دارید.
                </div>
                <div>
                    <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-dark">مشاهده اعلان‌ها</a>
                </div>
            </div>
        @endif
    
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleBtn = document.getElementById('menuToggleBtn');
    const closeMenuBtn = document.getElementById('closeMenuBtn');

    function toggleSidebar() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    function closeSidebar() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }

    toggleBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', closeSidebar);
    closeMenuBtn.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) {
            closeSidebar();
        }
    });
</script>

</body>
</html>
