<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقویم رویدادها</title>

    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS اصلی FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.13/main.min.css" rel="stylesheet">
    <!-- CSS FullCalendar DayGrid برای نمایش ماه -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.13/main.min.css" rel="stylesheet">
    <!-- CSS FullCalendar Bootstrap Theme -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.13/main.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Vazir', sans-serif !important;
            direction: rtl;
            background-color: #f0f2f5;
        }
        #calendar {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .fc-event-main-frame {
            padding: 5px;
        }
        .fc-toolbar-title {
            font-family: 'Vazir', sans-serif;
            font-size: 1.5rem;
        }
        .fc-toolbar-chunk, .fc-button {
            direction: ltr; /* برای دکمه‌ها و ناوبری تقویم */
        }
    </style>
</head>
<body>

<div id='calendar'></div>

<!-- JavaScript Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS اصلی FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.13/index.global.min.js"></script>
<!-- پلاگین FullCalendar برای نمایش ماه -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.13/index.global.min.js"></script>
<!-- پلاگین FullCalendar برای Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.13/index.global.min.js"></script>
<!-- پلاگین Persian Calendar برای FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar-jalali@2.0.2/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'dayGrid', 'bootstrap5', 'jalali' ], // استفاده از پلاگین‌ها
            initialView: 'dayGridMonth',
            locale: 'fa', // تنظیم زبان به فارسی
            direction: 'rtl', // تنظیم جهت به راست به چپ
            headerToolbar: {
                right: 'prev,next today',
                center: 'title',
                left: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            buttonText: {
                today: 'امروز',
                month: 'ماه',
                week: 'هفته',
                day: 'روز'
            },
            // اتصال به API برای دریافت رویدادها
            events: '{{ route('events.api') }}',
            // رویدادها را از مسیر جدید دریافت می‌کند
            eventDidMount: function(info) {
                // می‌توانید اینجا رویدادهای بیشتری را به رویدادهای تقویم اضافه کنید
                // مثلاً نمایش tooltip با اطلاعات بیشتر
            }
        });
        calendar.render();
    });
</script>

</body>
</html>
