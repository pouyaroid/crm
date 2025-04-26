<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>پنل مدیریت - آمار شکایت‌ها</title>
    
    <!-- استایل‌های اصلی -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel='stylesheet'>
    <link href='https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'>
    <script src='https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js'></script>
    
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
            min-height: 100vh;
            padding: 20px;
        }

        .navbar {
            background: linear-gradient(to left, var(--primary-color), var(--secondary-color));
            animation: fadeInDown 0.8s ease;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.25rem;
        }

        .stats-card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff;
            text-align: center;
            padding: 1.5rem;
            animation: fadeIn 0.6s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .stats-card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .chart-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-top: 2rem;
            max-height: 400px;
            overflow: auto;
            animation: fadeIn 0.8s ease;
        }

        .chart-title {
            text-align: center;
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        /* استایل داشبورد کناری */
        .sidebar {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: fit-content;
            animation: fadeIn 0.8s ease;
        }

        .sidebar-title {
            text-align: center;
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .sidebar-item {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--dark-color);
            text-decoration: none;
            border-radius: 10px;
            transition: background 0.3s, color 0.3s;
            margin-bottom: 0.5rem;
        }

        .sidebar-item:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .sidebar-item i {
            margin-left: 0.5rem;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 1rem;
            }
            .chart-container {
                height: 300px;
                max-height: none;
            }
            .sidebar {
                margin-top: 2rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class='bg-light'>

<!-- نوار ناوبری -->
<nav class='navbar navbar-expand-lg navbar-dark shadow-sm'>
    <div class='container-fluid'>
        <a class='navbar-brand' href='#'>
            <i class='fas fa-chart-line'></i> پنل آمار
        </a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav ms-auto'>
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route('complaints.my') }}'>بازگشت به شکایت‌ها</a>
                </li>
                <li class='nav-item'>
                    <form method='POST' action='{{ route('logout') }}' class='d-inline'>
                        @csrf
                        <button type='submit' class='btn btn-outline-light btn-sm'>خروج</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class='container py-5'>
    <div class='row'>
        <!-- محتوای اصلی -->
        <div class='col-lg-9 col-md-12'>
            <!-- کارت‌های خلاصه آمار -->
            <div class='row mb-4 g-4'>
                <div class='col-md-6 col-lg-3'>
                    <div class='stats-card bg-success text-white'>
                        <i class='fas fa-file-alt'></i>
                        <h5>تعداد شکایت‌های جدید</h5>
                        <p class='display-4'>{{ $statusCounts['new'] ?? 0 }}</p>
                    </div>
                </div>
                <div class='col-md-6 col-lg-3'>
                    <div class='stats-card bg-warning text-dark'>
                        <i class='fas fa-hourglass-half'></i>
                        <h5>در حال بررسی</h5>
                        <p class='display-4'>{{ $statusCounts['in_progress'] ?? 0 }}</p>
                    </div>
                </div>
                <div class='col-md-6 col-lg-3'>
                    <div class='stats-card bg-info text-white'>
                        <i class='fas fa-check-circle'></i>
                        <h5>پاسخ داده شده</h5>
                        <p class='display-4'>{{ $statusCounts['answered'] ?? 0 }}</p>
                    </div>
                </div>
                <div class='col-md-6 col-lg-3'>
                    <div class='stats-card bg-secondary text-white'>
                        <i class='fas fa-times-circle'></i>
                        <h5>بسته شده</h5>
                        <p class='display-4'>{{ $statusCounts['closed'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- نمودار -->
            <div class='chart-container'>
                <h4 class='chart-title'><i class='fas fa-chart-bar'></i> نمودار آماری وضعیت شکایت‌ها</h4>
                <canvas id='statusChart'></canvas>
            </div>
        </div>

        <!-- داشبورد کناری -->
        <div class='col-lg-3 col-md-12'>
            <div class='sidebar'>
                <h4 class='sidebar-title'><i class='fas fa-clipboard-list'></i> گزارش‌ها</h4>
                <a href='{{ route('admin.reports') }}' class='sidebar-item'><i class='fas fa-list'></i> گزارش کل</a>
                <a href='{{ route('admin.sevenreports') }}' class='sidebar-item'><i class='fas fa-calendar-week'></i> گزارش هفتگی</a>
                <a href='{{ route('admin.monthreports') }}' class='sidebar-item'><i class='fas fa-calendar-alt'></i> گزارش ماهانه</a>
                <a href='{{ route('admin.yearreports') }}' class='sidebar-item'><i class='fas fa-calendar'></i> گزارش سالانه</a>
                <a href='{{ route('reports.custom.form') }}' class='sidebar-item'><i class='fas fa-sliders-h'></i> گزارش دلخواه</a>
            </div>
        </div>
    </div>
</div>

<script>
    let statusChart; // ذخیره نمونه نمودار در متغیر گلوبال

    function initializeChart() {
        const ctx = document.getElementById('statusChart').getContext('2d');
        
        // داده‌های نمودار
        const dataValues = [
            {{ $statusCounts['new'] ?? 0 }},
            {{ $statusCounts['in_progress'] ?? 0 }},
            {{ $statusCounts['answered'] ?? 0 }},
            {{ $statusCounts['closed'] ?? 0 }}
        ];
        
        // محاسبه حداکثر مقدار داده برای تنظیم suggestedMax
        const maxDataValue = Math.max(...dataValues, 1); // حداقل 1 برای جلوگیری از خطا اگر همه داده‌ها صفر باشند
        const suggestedMaxValue = Math.ceil(maxDataValue * 1.2); // 20% بیشتر از حداکثر داده برای فضای بیشتر

        // پیکربندی داده‌ها
        const chartData = {
            labels: ['جدید', 'در حال بررسی', 'پاسخ داده شده', 'بسته شده'],
            datasets: [{
                label: 'تعداد شکایت‌ها',
                data: dataValues,
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)', // سبز برای جدید
                    'rgba(255, 193, 7, 0.8)', // زرد برای در حال بررسی
                    'rgba(0, 123, 255, 0.8)', // آبی برای پاسخ داده شده
                    'rgba(108, 117, 125, 0.8)' // خاکستری برای بسته شده
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(0, 123, 255, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8
            }]
        };

        // پیکربندی نمودار با تنظیمات بهینه‌سازی شده
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: { size: 14 },
                        color: '#495057'
                    }
                },
                tooltip: {
                    rtl: true,
                    bodyFont: { size: 14 },
                    callbacks: {
                        label: (ctx) => ` ${ctx.label}: ${ctx.raw} مورد`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: suggestedMaxValue, // تنظیم حداکثر مقدار بر اساس داده‌ها
                    grid: { color: '#e9ecef' },
                    ticks: { 
                        stepSize: 1,
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'تعداد شکایت‌ها',
                        font: { size: 14, weight: 'bold' }
                    }
                },
                x: {
                    grid: { display: false },
                    title: {
                        display: true,
                        text: 'وضعیت شکایت',
                        font: { size: 14, weight: 'bold' }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            }
        };

        // حذف نمونه قبلی نمودار در صورت وجود
        if (statusChart) statusChart.destroy();
        
        // ایجاد نمونه جدید نمودار
        statusChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: chartOptions
        });
    }

    // مقداردهی اولیه نمودار پس از لود صفحه
    document.addEventListener('DOMContentLoaded', initializeChart);
</script>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
