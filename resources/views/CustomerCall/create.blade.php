<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت تماس</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- Persian Datepicker CSS (نسخه پایدار) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.1.1/dist/css/persian-datepicker.min.css">

    <style>
        @import url('https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.3/Vazirmatn-font-face.css');
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f8f9fa;
            direction: rtl;
        }
        h4 {
            color: #4f46e5;
            font-weight: bold;
        }
        .btn-success {
            border-radius: 0.5rem;
        }
        .form-control {
            border-radius: 0.375rem;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
<div class="container py-5">
    <div class="card p-4">
        <h4 class="mb-4 text-center">ثبت تماس برای {{ $customer->company_name ?? 'مشتری' }}</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.calls.store', $customer->id ?? 1) }}" method="POST" id="callForm">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">عنوان تماس</label>
                <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="remind_at_jalali" class="form-label">تاریخ یادآور (اختیاری)</label>
                <input type="text" name="remind_at_jalali" id="remind_at_jalali" class="form-control" placeholder="مثلاً 1404/05/10" value="{{ old('remind_at_jalali') }}">
                {{-- hidden input حذف شد --}}
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success px-4 py-2">ثبت</button>
            </div>
        </form>
    </div>
</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.1.1/dist/js/persian-datepicker.min.js"></script>

<script>
$(document).ready(function () {
    $("#remind_at_jalali").persianDatepicker({
        calendar: {
            persian: {
                locale: 'fa',
                leapYearMode: 'astronomical'
            }
        },
        // بعد از انتخاب تاریخ، تاریخ شمسی در input قرار داده می‌شود
        onSelect: function (date) {
            // تبدیل تاریخ شمسی به رشته‌ای که با سرور هماهنگ باشد
            let jalaliDate = date.format('YYYY/MM/DD');
            $("#remind_at_jalali").val(jalaliDate); // قرار دادن تاریخ شمسی در input
        }
    });
});

</script>
</body>
</html>

