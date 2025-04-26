<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>گزارش وضعیت‌ها</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Vazirmatn', Tahoma, Arial, sans-serif; /* فونت فارسی بهتر برای حرفه‌ای‌تر شدن */
        }
        .report-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        .chart-container {
            margin-top: 30px;
            margin-bottom: 30px;
            height: 400px; /* افزایش ارتفاع برای بهتر دیده شدن */
        }
        .summary-card {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .table th, .table td {
            text-align: center; /* مرکز کردن متن در جدول */
        }
        .btn-back {
            transition: all 0.3s ease; /* انیمیشن برای دکمه بازگشت */
        }
        .btn-back:hover {
            transform: translateX(5px); /* حرکت کوچک به چپ هنگام hover */
        }
        /* استایل برای انیمیشن fade-in */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class='fade-in'> <!-- اضافه کردن انیمیشن fade-in به کل صفحه -->
    <div class='container report-container'>
        <div class='card shadow-lg border-0'>
            <div class='card-header bg-gradient-primary text-white text-center py-4'>
                <h2 class='mb-0'>گزارش از {{ $startDate }} تا {{ $endDate }}</h2>
            </div>
            <div class='card-body'>
                @if($report->isNotEmpty())
                    @php
                        $totalCount = array_sum($report->toArray()); // محاسبه مجموع در Blade
                    @endphp

                    <!-- بخش خلاصه آمار -->
                    <div class='summary-card mb-4'>
                        <h5 class='text-primary'><i class='bi bi-bar-chart-fill me-2'></i> خلاصه گزارش</h5>
                        <p class='mb-2'>تعداد کل رکوردها: <strong>{{ $totalCount }}</strong></p>
                        <!-- نمایش درصد هر وضعیت -->
                        @foreach($report as $status => $count)
                            <p class='mb-1'>وضعیت '{{ $status }}': <strong>{{ number_format(($count / $totalCount) * 100, 2) }}%</strong> (تعداد: {{ $count }})</p>
                        @endforeach
                    </div>

                    <!-- جدول با استایل حرفه‌ای‌تر -->
                    <div class='table-responsive mb-4'>
                        <table class='table table-striped table-hover table-bordered align-middle'>
                            <thead class='table-primary'>
                                <tr>
                                    <th class='text-center'>وضعیت</th>
                                    <th class='text-center'>تعداد</th>
                                    <th class='text-center'>درصد</th> <!-- اضافه کردن ستون درصد -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report as $status => $count)
                                    <tr>
                                        <td>{{ $status }}</td>
                                        <td class='text-center'>{{ $count }}</td>
                                        <td class='text-center'>{{ number_format(($count / $totalCount) * 100, 2) }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- نمودار بهبود یافته با Bar Chart برای بهتر مقایسه شدن -->
                    <div class='chart-container'>
                        <canvas id='statusChart'></canvas>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('statusChart').getContext('2d');
                            
                            // استخراج labels و data از PHP
                            const labels = [@foreach($report as $status => $count) '{{ $status }}', @endforeach];
                            const data = [@foreach($report as $count) {{ $count }}, @endforeach];
                            
                            const chart = new Chart(ctx, {
                                type: 'bar', // تغییر به bar chart برای حرفه‌ای‌تر شدن
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'تعداد وضعیت‌ها',
                                        data: data,
                                        backgroundColor: [
                                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', 
                                            '#858796', '#5a5c69', '#6f42c1', '#20c9a6', '#fd7e14'
                                        ],
                                        borderColor: '#ffffff',
                                        borderWidth: 1,
                                        barThickness: 40, // تنظیم ضخامت میله‌ها
                                        maxBarThickness: 60
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1, // گام‌های صحیح برای تعداد
                                                callback: function(value) { return value; }
                                            }
                                        },
                                        x: {
                                            ticks: {
                                                autoSkip: false
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top',
                                            labels: {
                                                font: {
                                                    size: 14
                                                }
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'توزیع وضعیت‌ها',
                                            font: {
                                                size: 18,
                                                weight: 'bold'
                                            },
                                            padding: {
                                                top: 10,
                                                bottom: 30
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    let label = context.label || '';
                                                    if (label) {
                                                        label += ': ';
                                                    }
                                                    label += context.raw;
                                                    return label;
                                                }
                                            }
                                        }
                                    },
                                    animation: {
                                        duration: 1000, // انیمیشن برای ورود داده‌ها
                                        easing: 'easeInOutCubic'
                                    }
                                }
                            });
                        });
                    </script>

                @else
                    <!-- هشدار عدم وجود داده با طراحی بهتر -->
                    <div class='alert alert-warning d-flex align-items-center justify-content-center p-4'>
                        <i class='bi bi-exclamation-triangle-fill fs-1 me-3'></i>
                        <div>
                            <h4 class='alert-heading'>داده‌ای یافت نشد!</h4>
                            <p class='mb-0'>متأسفانه هیچ داده‌ای در بازه زمانی انتخاب‌شده وجود ندارد. لطفاً بازه زمانی دیگری را امتحان کنید.</p>
                        </div>
                    </div>
                @endif

                <!-- دکمه بازگشت با انیمیشن -->
                <div class='text-center mt-5'>
                    <a href='{{ route('reports.custom.form') }}' class='btn btn-primary btn-lg btn-back'>
                        <i class='bi bi-arrow-right me-2'></i> بازگشت به فرم
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
