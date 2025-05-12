<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>تأیید ثبت شکایت</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- بوت‌استرپ RTL از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
            text-align: right;
            padding: 30px;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
            max-width: 600px;
            margin: auto;
            padding: 30px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #666;
        }
        blockquote {
            background-color: #f1f1f1;
            border-right: 4px solid #0d6efd;
            padding: 15px;
            border-radius: 8px;
            font-size: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2 class="mb-4">سلام {{ $user->name }} عزیز 🌟</h2>
        <p>شکایت شما با عنوان زیر با موفقیت در سیستم ثبت شد:</p>
        <h5 class="text-primary my-3">«{{ $complaint->title }}»</h5>

        <p>جزئیات شکایت شما:</p>
        <blockquote>{{ $complaint->description }}</blockquote>

        <div class="text-center my-4">
            <a href="{{ url('/complaints/' . $complaint->id) }}" class="btn btn-primary">مشاهده شکایت</a>
        </div>

        <p class="footer text-center">
            با تشکر از اعتماد شما 💙<br>
            تیم پشتیبانی کاوه سلولز زرین
        </p>
    </div>
</body>
</html>
