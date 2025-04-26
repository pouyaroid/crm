
<div class='container py-5'>
    <h3 class='text-center mb-4'>گزارش 30 روز اخیر</h3>

    <div class='chart-container'>
        <canvas id='last7DaysChart'></canvas>
    </div>

    <p class='text-center mt-4'>تعداد شکایات در 30 روز اخیر:</p>
    @foreach( $last30DaysCounts as $status => $count)
        <p class='text-center'>{{ $status }}: {{ $count }} مورد</p>
    @endforeach
</div>




<script src='https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('last7DaysChart').getContext('2d');
        
        const dataValues = [
            @foreach( $last30DaysCounts as $count)
                {{ $count }},
            @endforeach
        ];

        const statusLabels = [
            'جدید', 'در حال بررسی', 'پاسخ داده شده', 'بسته شده', 'رد شده'
        ];

        const  $last30DaysCounts = new Chart(ctx, {
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

