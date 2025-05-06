<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ارسال پیام تکی</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            background-color: #f2f4f6;
        }
        .form-box {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.07);
            max-width: 600px;
            margin: 50px auto;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
        }
        textarea {
            resize: vertical;
            padding: 12px;
            font-size: 15px;
        }
        .btn-primary {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            border-radius: 8px;
        }
        @media (max-width: 576px) {
            .form-box {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="form-box">
    <h4 class="mb-4 text-center text-primary">ارسال پیام به {{ $customer->name }}</h4>

    <form method="POST" action="{{ route('customers.message.single.send') }}">
        @csrf
        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

        <div class="mb-3">
            <label for="message">متن پیام:</label>
            <textarea name="message" id="message" class="form-control" rows="5" placeholder="متن پیام را وارد کنید" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">ارسال</button>
    </form>
</div>

</body>
</html>
