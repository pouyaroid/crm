@extends('layouts.app')

@section('title', 'گزارش 30 روز اخیر')

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

    .status-card {
        background-color: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        margin-bottom: 20px;
    }

    .status-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .status-title {
        font-size: 18px;
        color: #007bff;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .status-count {
        font-size: 24px;
        color: #333;
        font-weight: 700;
    }

    .fs-5 {
        font-size: 1.25rem !important;
    }

    /* Flexbox for responsiveness */
    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .col-12 {
        flex: 0 0 100%;
    }

    .col-md-4 {
        flex: 0 0 30%;
        max-width: 30%;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        h3 {
            font-size: 1.5rem;
        }

        .status-card {
            padding: 15px;
        }

        .status-title {
            font-size: 16px;
        }

        .status-count {
            font-size: 20px;
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

        .status-card {
            padding: 10px;
        }

        .status-title {
            font-size: 14px;
        }

        .status-count {
            font-size: 18px;
        }
    }
</style>

<div class="container py-5">
    <h3 class="mb-4">📊 گزارش 30 روز اخیر</h3>

    <!-- Chart Section -->
    <div class="chart-container mb-5">
        <canvas id="last7DaysChart"></canvas>
    </div>

    <p class="text-center fs-5 text-muted">تعداد شکایات در 30 روز اخیر:</p>

    <div class="row">
        @foreach($last30DaysCounts as $status => $count)
            <div class="col-12 col-md-4 mb-3">
                <div class="status-card">
                    <h5 class="status-title">{{ $status }}</h5>
                    <p class="status-count">{{ $count }} مورد</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- External Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('last7DaysChart').getContext('2d');

        const dataValues = [
            @foreach($last30DaysCounts as $count)
                {{ $count }},
            @endforeach
        ];

        const statusLabels = [
            'جدید', 'در حال بررسی', 'پاسخ داده شده', 'بسته شده', 'رد شده'
        ];

        new Chart(ctx, {
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
                    borderRadius: 10,
                    borderColor: 'rgba(0,0,0,0.1)',
                    borderWidth: 1
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
                        display: false
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
