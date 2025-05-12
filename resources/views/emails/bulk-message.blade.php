<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <style>
        body { direction: rtl; font-family: Tahoma, sans-serif; background-color: #f9f9f9; padding: 20px; }
        .content { background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
        .footer { margin-top: 20px; font-size: 12px; color: gray; }
    </style>
</head>
<body>
    <div class="content">
        <h2>سلام {{ $customer->fullname ?? 'مشتری عزیز' }} 👋</h2>
        <p>{!! nl2br(e($messageText)) !!}</p>

        <div class="footer">
            <p>با احترام،</p>
            <p>تیم پشتیبانی شما</p>
        </div>
    </div>
</body>
</html>
