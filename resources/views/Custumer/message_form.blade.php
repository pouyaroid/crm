<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نوشتن پیام گروهی</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            background-color: #f2f4f6;
        }
        .container {
            max-width: 800px;
            margin-top: 40px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        }
        h2 {
            text-align: center;
            color: #198754;
            font-weight: bold;
            margin-bottom: 25px;
        }
        label {
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }
        textarea {
            resize: vertical;
            font-size: 15px;
            padding: 12px;
        }
        .btn-success {
            width: 100%;
            font-size: 16px;
            padding: 12px;
            border-radius: 10px;
        }
        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>نوشتن پیام گروهی</h2>

    <form method="POST" action="{{ route('customers.message.send') }}">
        @csrf

        @foreach($ids as $id)
            <input type="hidden" name="customer_ids[]" value="{{ $id }}">
        @endforeach

        <div class="mb-3">
            <label for="message">متن پیام:</label>
            <textarea name="message" rows="6" class="form-control" id="message" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">ارسال پیام</button>
    </form>
</div>

</body>
</html>
