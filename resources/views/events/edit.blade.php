@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>ویرایش رویداد: {{ $event->title }}</h2>
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

    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="title" class="form-label">عنوان</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="location" class="form-label">محل برگزاری</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $event->location) }}" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="event_date_jalali" class="form-label">تاریخ شروع</label>
                <input type="text" class="form-control jalali-datepicker" id="event_date_jalali" name="event_date_jalali" value="{{ old('event_date_jalali', $event->event_date_jalali) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date_jalali" class="form-label">تاریخ پایان (اختیاری)</label>
                <input type="text" class="form-control jalali-datepicker" id="end_date_jalali" name="end_date_jalali" value="{{ old('end_date_jalali', $event->end_date_jalali) }}">
            </div>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-warning">به‌روزرسانی رویداد</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.ui.datepicker-jalali/1.4.1/jquery.ui.datepicker-jalali.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.ui.datepicker-jalali/1.4.1/jquery.ui.datepicker-jalali-fa.min.js"></script>

<script>
    $(document).ready(function() {
        $('.jalali-datepicker').datepicker({
            dateFormat: 'yy/mm/dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        });
    });
</script>
@endpush