
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'پنل مدیریت')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap RTL + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn-font/dist/font-face.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: #e9ecef;
        }

        .container-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(to bottom, #1c1f24, #343a40);
            color: white;
            padding-top: 1rem;
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 1050;
            transition: transform 0.3s ease;
            box-shadow: -3px 0 8px rgba(0, 0, 0, 0.3);
        }

        .sidebar h4 {
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: #ffc107;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.2rem;
            color: #ced4da;
            transition: background-color 0.2s, color 0.2s;
            border-right: 3px solid transparent;
        }

        .sidebar .nav-link i {
            margin-left: 0.75rem;
            font-size: 1.2rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #495057;
            color: #ffffff;
            border-right: 3px solid #ffc107;
        }

        .content-wrapper {
            margin-right: 260px;
            padding: 2rem;
            flex-grow: 1;
            background: #f8f9fa;
        }

        .btn-toggle {
            background-color: #343a40;
            color: #fff;
            border: none;
            font-size: 1rem;
        }

        .btn-toggle:hover {
            background-color: #495057;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }

            .overlay.show {
                display: block;
            }

            .content-wrapper {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

<div class="container-wrapper">
    <!-- Sidebar -->
    <div class="sidebar d-md-block" id="sidebar">
        <h4><i class="bi bi-speedometer2 me-2"></i>CRM رشد</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('complaints.admin.index') ? 'active' : '' }}" href="{{ route('complaints.admin.index') }}">
                    <i class="bi bi-inbox-fill"></i> لیست شکایات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                    <i class="bi bi-graph-up-arrow"></i> گزارش شکایات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">
                    <i class="bi bi-person-plus"></i> ساخت کاربر
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i> کاربران
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.create') ? 'active' : '' }}" href="{{ route('customers.create') }}">
                    <i class="bi bi-person-plus-fill"></i> ثبت مشتری
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                    <i class="bi bi-people-fill"></i> لیست مشتریان
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tracking.create.form') ? 'active' : '' }}" href="{{ route('tracking.create.form') }}">
                    <i class="bi bi-plus-square"></i> ثبت رهگیری
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tracking.index') ? 'active' : '' }}" href="{{ route('tracking.index') }}">
                    <i class="bi bi-box-arrow-in-up-right"></i> مشاهده رهگیری
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leads.create') ? 'active' : '' }}" href="{{ route('leads.create') }}">
                    <i class="bi bi-lightbulb-fill"></i> سرنخ جدید
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leads.index') ? 'active' : '' }}" href="{{ route('leads.index') }}">
                    <i class="bi bi-search-heart"></i> مشاهده سرنخ‌ها
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leads.report') ? 'active' : '' }}" href="{{ route('leads.report') }}">
                    <i class="bi bi-clipboard2-data"></i> گزارش سرنخ‌ها
                </a>
            </li>
            <li class="nav-item mt-3">
                <a class="nav-link" href="#">
                    <i class="bi bi-gear"></i> تنظیمات
                </a>
            </li>
            <li class="nav-item d-md-none">
                <a class="nav-link text-danger" href="javascript:void(0);" onclick="toggleSidebar()">
                    <i class="bi bi-x-lg"></i> بستن منو
                </a>
            </li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class="overlay d-md-none" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Toggle Sidebar -->
        <button class="btn btn-toggle d-md-none mb-3" id="menuToggleBtn">
            <i class="bi bi-list"></i> منو
        </button>

        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar(forceClose = false) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        if(forceClose){
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        } else {
            const isOpen = sidebar.classList.contains('show');
            sidebar.classList.toggle('show', !isOpen);
            overlay.classList.toggle('show', !isOpen);
        }
    }

    document.getElementById('menuToggleBtn').addEventListener('click', function () {
        toggleSidebar();
    });

    // Optionally hide on resize to md+ screens
    window.addEventListener('resize', function(){
        if(window.innerWidth >= 768){
            toggleSidebar(true);
        }
    });
</script>

</body>
</html>
