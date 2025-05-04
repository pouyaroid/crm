<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت تماس خروجی</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@400;700&display=swap" rel="stylesheet">
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

            <div class="mb-3">
                <label for="call_time" class="form-label">زمان تماس</label>
                <input type="datetime-local" id="call_time" name="call_time" class="form-control @error('call_time') is-invalid @enderror">
                @error('call_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">ثبت تماس</button>
        </form>
    </div>
</div>
</body>
</html>
