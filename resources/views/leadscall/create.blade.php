<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت تماس خروجی</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background-color: #f1f3f5;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <h4 class="text-center mb-4">ثبت تماس خروجی برای: {{ $lead->name }}</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('leads.calls.store', $lead) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="call_summary" class="form-label">خلاصه تماس</label>
                <input type="text" id="call_summary" name="call_summary" class="form-control @error('call_summary') is-invalid @enderror" required>
                @error('call_summary')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">یادداشت</label>
                <textarea id="notes" name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror"></textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- فیلد ورودی تاریخ و زمان شمسی --}}
            <div class="mb-3">
                <label for="call_time_jalali" class="form-label">زمان تماس (شمسی)</label>
                <input type="text" id="call_time_jalali" name="call_time_jalali" class="form-control @error('call_time_jalali') is-invalid @enderror" required>
                @error('call_time_jalali')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                {{-- فیلد پنهان برای ارسال تاریخ میلادی به سرور --}}
                <input type="hidden" id="call_time_gregorian" name="call_time_gregorian">
            </div>

            <button type="submit" class="btn btn-primary w-100">ثبت تماس</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

<script>
    $(document).ready(function() {
        // فعال کردن Persian Datepicker برای فیلد call_time_jalali
        $("#call_time_jalali").pDatepicker({
            format: 'YYYY/MM/DD HH:mm', // فرمت نمایش تاریخ و زمان شمسی
            autoClose: true,
            altField: '#call_time_gregorian', // فیلد پنهان برای ذخیره تاریخ میلادی
            altFormat: 'YYYY-MM-DD HH:mm:00', // فرمت تاریخ میلادی برای ارسال به سرور
            timePicker: {
                enabled: true, // فعال کردن انتخاب زمان
                meridiem: {
                    enabled: false // غیرفعال کردن AM/PM
                }
            },
            observer: true, // تغییرات را مشاهده می‌کند
            onSelect: function(unix) {
                // این تابع هنگام انتخاب تاریخ اجرا می‌شود.
                // تاریخ میلادی در فیلد پنهان call_time_gregorian قرار گرفته است.
                // می‌توانید اینجا یک console.log برای تست اضافه کنید:
                // console.log($('#call_time_gregorian').val());
            }
        });

        // اگر فیلد call_time_gregorian قبلاً مقداری داشته باشد (مثلاً در صورت ویرایش یا خطا پس از ارسال)
        // آن را به Datepicker منتقل می‌کنیم تا تاریخ شمسی نمایش داده شود.
        // این بخش را اگر فقط برای ثبت تماس جدید است، می‌توانید حذف کنید.
        const initialGregorianDate = $('#call_time_gregorian').val();
        if (initialGregorianDate) {
            // تبدیل تاریخ میلادی (ISO) به شیء PersianDate و تنظیم آن در datepicker
            const pdate = new persianDate(new Date(initialGregorianDate));
            $("#call_time_jalali").pDatepicker("setDate", pdate);
        }
    });
</script>
</body>
</html>