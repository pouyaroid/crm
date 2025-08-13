@extends('layouts.app')

@section('title', 'گزارش شکایات در یک سال اخیر')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

<!-- Main Styling -->
<style>
    body {
        font-family: 'Vazirmatn', sans-serif;
        background-color: #f8f9fa;
        direction: rtl;
        margin: 0;
    }

    .container {
        margin-top: 50px;
    }

    h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #007bff;
        text-align: center;
    }

    .chart-container {
        position: relative;
        width: 100%;
        height: 400px;
        background: linear-gradient(45deg, rgba(0, 123, 255, 0.2), rgba(0, 123, 255, 0.1));
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 40px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .chart-container:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 123, 255, 0.2);
    }

    .status-item {
        font-size: 18px;
        color: #333;
        font-weight: 600;
        margin-bottom: 10px;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        h3 {
            font-size: 1.5rem;
        }

        .status-item {
            font-size: 16px;
        }

        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .chart-container {
            height: 300px;
        }
    }

    @media (max-width: 480px) {
        h3 {
            font-size: 1.25rem;
        }

        .status-item {
            font-size: 14px;
        }
    }
</style>

<div class="container py-5">
    <h3 class="mb-4">📊 گزارش شکایات در یک سال اخیر</h3>

    <!-- Chart Section -->
    <div class="chart-container mb-5">
        <canvas id="lastYearChart"></canvas>
    </div>

    <p class="text-center mt-4 fs-5 text-muted">تعداد شکایات در یک سال اخیر:</p>

    <!-- Displaying Dynamic Content with Blade -->
    <div class="row justify-content-center">
        @foreach($lastYearCounts as $status => $count)
            <div class="col-12 col-md-4 mb-3">
                <p class="text-center status-item">
                    <strong>{{ $status }}:</strong> {{ $count }} مورد
                </p>
            </div>
        @endforeach
    </div>
</div>

<!-- External Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('lastYearChart').getContext('2d');

        // داده‌های تعداد شکایات در یک سال اخیر که از Blade ارسال شده
        const dataValues = [
            @foreach($lastYearCounts as $status => $count)
                {{ $count }},
            @endforeach
        ];

        const statusLabels = [
            'جدید', 'در حال بررسی', 'پاسخ داده شده', 'بسته شده', 'رد شده'
        ];

        const lastYearChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'تعداد شکایات',
                    data: dataValues,
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)', // سبز برای جدید
                        'rgba(255, 193, 7, 0.8)', // زرد برای در حال بررسی
                        'rgba(0, 123, 255, 0.8)', // آبی برای پاسخ داده شده
                        'rgba(108, 117, 125, 0.8)', // خاکستری برای بسته شده
                        'rgba(255, 0, 0, 0.8)' // قرمز برای رد شده
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'تعداد شکایات'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        rtl: true,
                        callbacks: {
                            label: (tooltipItem) => tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' مورد'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
