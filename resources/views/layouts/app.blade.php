<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'پنل مدیریت')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn-font/dist/font-face.css" rel="stylesheet" />
    
    <style>
        :root {
            --sidebar-width-lg: 280px; /* Width of sidebar on large screens */
            --sidebar-transition-duration: 0.3s;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            overflow-x: hidden; /* Prevent horizontal scroll from layout itself */
        }

        /* Wrapper for sidebar and content */
        .wrapper {
            display: flex;
            min-height: 100vh;
            background: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width-lg);
            background: linear-gradient(135deg, #1f2937, #4b5563);
            color: #e0e7ff;
            padding-top: 1.5rem;
            position: fixed; /* Keep sidebar fixed */
            right: 0;
            top: 0;
            bottom: 0;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.25);
            z-index: 1050; /* Ensure sidebar is above content and overlay */
            display: flex;
            flex-direction: column;
            transition: right var(--sidebar-transition-duration) ease;
            
            /* Initially hide on small screens */
            right: calc(-1 * var(--sidebar-width-lg)); /* Start off-screen to the right */
        }

        /* Show sidebar on large screens */
        @media (min-width: 992px) {
            .sidebar {
                right: 0; /* Always visible on large screens */
            }
        }

        /* Show sidebar when toggled (mobile) */
        .sidebar.show {
            right: 0;
        }
        
        /* New CSS for scrollable content inside sidebar */
        .sidebar-scrollable {
            flex-grow: 1; /* Allow content to grow and fill available space */
            overflow-y: auto; /* Enable vertical scrolling */
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

        /* Close button for mobile menu */
        .btn-close-menu {
            display: none; /* Hidden by default */
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
        /* Show close button on small screens */
        @media (max-width: 991.98px) {
            .btn-close-menu {
                display: inline-block;
            }
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
        
        .sidebar-menu {
            /* Remove the border from the last nav item since we're adding it to the ul instead */
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
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

        /* Main content wrapper */
        .content-wrapper {
            flex-grow: 1;
            padding: 2rem 2.5rem;
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-right var(--sidebar-transition-duration) ease;
            margin-right: 0; /* Default for small screens */
        }

        /* Adjust content margin on large screens when sidebar is visible */
        @media (min-width: 992px) {
            .content-wrapper {
                margin-right: var(--sidebar-width-lg); /* Push content to the left of sidebar */
            }
        }

        /* Overlay for small screens when sidebar is open */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1040; /* Below sidebar, above content */
            transition: opacity var(--sidebar-transition-duration) ease;
            opacity: 0;
        }
        .overlay.show {
            display: block;
            opacity: 1;
        }

        /* Menu Toggle Button (for mobile) */
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
    @stack('styles') {{-- This line is crucial for page-specific styles --}}
</head>
<body>

<div class="wrapper">
    <nav class="sidebar" id="sidebar" aria-label="منوی اصلی">
        <div class="sidebar-header" tabindex="0">
            <div>
                <i class="bi bi-speedometer2"></i> CRM رشد
            </div>
            <button class="btn-close-menu" id="closeMenuBtn" aria-label="بستن منو">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="user-info" aria-label="اطلاعات کاربر">
            <i class="bi bi-person-circle"></i>
            {{ auth()->user()->name ?? 'کاربر ناشناس' }}
        </div>
        
        <div class="sidebar-scrollable">
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
                <li class="nav-item">
                    <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.index') ? 'active' : '' }}">
                        <i class="bi bi-calendar3"></i> مشاهده رویداد
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('events.create') }}" class="nav-link {{ request()->routeIs('events.create') ? 'active' : '' }}">
                        <i class="bi bi-calendar2-plus"></i> ایجاد رویداد
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column mt-auto p-0">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-start text-danger w-100">
                            <i class="bi bi-box-arrow-left"></i> خروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="overlay" id="overlay" onclick="closeSidebar()"></div> {{-- Changed onclick to closeSidebar --}}

    <main class="content-wrapper">
        <button class="btn btn-toggle d-lg-none" id="menuToggleBtn" aria-label="بازکردن منو"> {{-- Changed d-md-none to d-lg-none --}}
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

    // Close sidebar if window is resized to large screen
    window.addEventListener('resize', () => {
        // Use a breakpoint consistent with your CSS (992px for lg)
        if (window.innerWidth >= 992) {
            closeSidebar(); // Ensure sidebar is hidden if it was open on mobile and user resizes
        }
    });
</script>

</body>
</html>