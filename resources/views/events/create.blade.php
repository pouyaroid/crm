@extends('layouts.app')

@section('title', 'ایجاد رویداد')

@section('content')
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ایجاد رویداد جدید</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  
  <!-- Persian Datepicker -->
  <link rel="stylesheet" href="https://unpkg.com/persian-datepicker/dist/css/persian-datepicker.min.css">

  <!-- فونت وزیر -->
  <style>
    @import url('https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.3/Vazirmatn-font-face.css');
    body {
      font-family: 'Vazirmatn', sans-serif;
      background-color: #f9fafb;
    }
    h2 {
      color: #4f46e5;
      font-weight: bold;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
      border-color: #6366f1;
    }
    .btn-primary {
      background-color: #6366f1;
      border-color: #6366f1;
    }
    .btn-primary:hover {
      background-color: #4f46e5;
      border-color: #4f46e5;
    }
    label {
      font-weight: 500;
      margin-bottom: 0.5rem;
    }
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="card p-4">
    <h2 class="mb-4 text-center">ایجاد رویداد جدید</h2>

    <hr class="mb-4">

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
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
          <label for="title" class="form-label">عنوان رویداد</label>
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
        <label for="description" class="form-label">توضیحات رویداد</label>
        <textarea class="form-control" id="description" name="description" rows="4" placeholder="توضیحی درباره‌ی این رویداد بنویسید...">{{ old('description') }}</textarea>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary px-4 py-2">ثبت رویداد</button>
      </div>
    </form>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker/dist/js/persian-datepicker.min.js"></script>

<script>
  $(document).ready(function () {
    $('#event_date_jalali').persianDatepicker({
      format: 'YYYY/MM/DD',
      calendarType: 'persian',
      autoClose: true,
      observer: true
    });
    $('#end_date_jalali').persianDatepicker({
      format: 'YYYY/MM/DD',
      calendarType: 'persian',
      autoClose: true,
      observer: true
    });
  });
</script>

</body>
</html>
@endsection