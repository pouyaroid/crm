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
        /*
        ===================================================
        فونت و متغیرهای اصلی
        ===================================================
        */
        :root {
            --sidebar-width-lg: 280px;
            --sidebar-transition-duration: 0.3s;
            --primary-color: #1a2a4b; /* آبی تیره برای پس‌زمینه سایدبار */
            --secondary-color: #273b64; /* رنگ روشن‌تر برای پس‌زمینه المان‌ها */
            --accent-color: #3b82f6; /* آبی روشن برای لینک‌ها و هایلایت */
            --text-light: #f1f5f9;
            --text-muted: #94a3b8;
            --active-color: #e3f2fd; /* رنگ پس‌زمینه فعال */
            --active-text: #1a2a4b; /* رنگ متن فعال */
            --danger-color: #f87171;
            --danger-hover: #ef4444;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #f1f5f9; /* پس‌زمینه روشن */
            min-height: 100vh;
            overflow-x: hidden;
            color: #334155;
            transition: background-color 0.3s ease;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            background: #f1f5f9;
        }

        /*
        ===================================================
        سایدبار (منوی کناری)
        ===================================================
        */
        .sidebar {
            width: var(--sidebar-width-lg);
            background: var(--primary-color);
            color: var(--text-light);
            padding-top: 1.5rem;
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: right var(--sidebar-transition-duration) ease, box-shadow 0.3s ease;
            right: calc(-1 * var(--sidebar-width-lg));
        }

        @media (min-width: 992px) {
            .sidebar {
                right: 0;
            }
        }

        .sidebar.show {
            right: 0;
        }

        .sidebar-scrollable {
            flex-grow: 1;
            overflow-y: auto;
        }
        
        /* مخفی کردن اسکرول‌بار در دسکتاپ */
        @media (min-width: 992px) {
            .sidebar-scrollable {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .sidebar-scrollable::-webkit-scrollbar {
                display: none;
            }
        }

        .sidebar-header {
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--accent-color);
            letter-spacing: 1px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            user-select: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-close-menu {
            display: none;
            background: transparent;
            border: none;
            color: var(--accent-color);
            font-size: 1.6rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .btn-close-menu:hover {
            color: var(--text-light);
        }
        @media (max-width: 991.98px) {
            .btn-close-menu {
                display: inline-block;
            }
        }

        .user-info {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 500;
            font-size: 1.1rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            user-select: none;
            border-radius: 8px;
            margin: 0.5rem 1rem;
            transition: background-color 0.3s ease;
        }
        .user-info i {
            font-size: 1.5rem;
            color: var(--accent-color);
        }

        /*
        ===================================================
        لینک‌های منو
        ===================================================
        */
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1.75rem;
            font-weight: 400;
            color: var(--text-light);
            border-right: 4px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }

        .sidebar .nav-link i {
            font-size: 1.4rem;
            color: var(--text-muted);
            transition: color 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: var(--secondary-color);
            border-right-color: var(--accent-color);
            color: var(--accent-color);
        }

        .sidebar .nav-link:hover i {
            color: var(--accent-color);
        }

        .sidebar .nav-link.active {
            background-color: var(--active-color);
            color: var(--active-text);
            font-weight: 600;
            border-right-color: var(--active-text);
        }

        .sidebar .nav-link.active i {
            color: var(--active-text);
        }

        .sidebar .nav-link:not(:last-child) {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .sidebar-menu {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .sidebar form button.nav-link {
            width: 100%;
            text-align: start;
            padding-left: 1.75rem;
            color: var(--danger-color);
            font-weight: 500;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .sidebar form button.nav-link:hover {
            background-color: rgba(248, 113, 113, 0.1);
            color: var(--danger-hover);
            border-right-color: var(--danger-hover);
        }

        /*
        ===================================================
        محتوای اصلی و المان‌ها
        ===================================================
        */
        .content-wrapper {
            flex-grow: 1;
            padding: 2rem 2.5rem;
            min-height: 100vh;
            background: #f1f5f9;
            transition: margin-right var(--sidebar-transition-duration) ease;
            margin-right: 0;
            position: relative;
        }

        @media (min-width: 992px) {
            .content-wrapper {
                margin-right: var(--sidebar-width-lg);
            }
        }

        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            transition: opacity var(--sidebar-transition-duration) ease;
            opacity: 0;
        }
        .overlay.show {
            display: block;
            opacity: 1;
        }

        .btn-toggle {
            background-color: var(--primary-color);
            color: var(--accent-color);
            border: none;
            font-size: 1rem;
            padding: 0.65rem 1.4rem;
            border-radius: 0.5rem;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            font-weight: 500;
        }
        .btn-toggle:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .btn-toggle i {
            vertical-align: middle;
            font-size: 1.6rem;
            margin-left: 0.5rem;
        }

        .alert {
            border-radius: 0.75rem;
            border: 1px solid rgba(0,0,0,0.1);
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
    </style>
    @stack('styles')
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

    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>

    <main class="content-wrapper">
        <button class="btn btn-toggle d-lg-none" id="menuToggleBtn" aria-label="بازکردن منو">
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