<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ایجاد رویداد جدید</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker/dist/css/persian-datepicker.min.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: right;
            direction: rtl;
        }
        .container {
            max-width: 800px;
        }
        .form-label {
            display: block;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>ایجاد رویداد جدید</h2>
    <hr>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="title" class="form-label">عنوان</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="location" class="form-label">محل برگزاری</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="event_date_jalali" class="form-label">تاریخ شروع</label>
                <input type="text" class="form-control" id="event_date_jalali" name="event_date_jalali" value="{{ old('event_date_jalali') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date_jalali" class="form-label">تاریخ پایان (اختیاری)</label>
                <input type="text" class="form-control" id="end_date_jalali" name="end_date_jalali" value="{{ old('end_date_jalali') }}">
            </div>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">ثبت رویداد</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker/dist/js/persian-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // فعال‌سازی Persian Datepicker برای فیلد تاریخ شروع
        $('#event_date_jalali').persianDatepicker({
            format: 'YYYY/MM/DD',
            calendarType: 'persian',
            autoClose: true,
            observer: true,
        });

        // فعال‌سازی Persian Datepicker برای فیلد تاریخ پایان
        $('#end_date_jalali').persianDatepicker({
            format: 'YYYY/MM/DD',
            calendarType: 'persian',
            autoClose: true,
            observer: true,
        });
    });
</script>

</body>
</html>