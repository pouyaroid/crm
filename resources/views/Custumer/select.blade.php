<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ارسال پیام گروهی</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin-top: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #0d6efd;
            font-weight: bold;
        }
        table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: #e9ecef;
            font-weight: 600;
        }
        td, th {
            vertical-align: middle;
            text-align: center;
        }
        input[type="checkbox"] {
            transform: scale(1.3);
            margin: 0;
        }
        .btn-primary {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            border-radius: 10px;
        }
        @media (max-width: 576px) {
            .table-responsive {
                font-size: 14px;
            }
            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>انتخاب مخاطبین برای ارسال پیام گروهی</h2>

    <form method="POST" action="{{ route('customers.message.form') }}">
        @csrf

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>انتخاب</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td><input type="checkbox" name="selected_customers[]" value="{{ $customer->id }}"></td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">ادامه به نوشتن پیام</button>
    </form>
</div>

</body>
</html>
