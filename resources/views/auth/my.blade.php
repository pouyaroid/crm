<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>شکایت‌های من</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css' rel='stylesheet'>
    <link href='https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css'>
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #50e3c2;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --info-color: #2196f3;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --background-gradient: linear-gradient(135deg, #f0f4f8 0%, #d9e4f5 100%);
        }

        body {
            font-family: 'Vazir', sans-serif;
            background: var(--background-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .complaint-card {
            max-width: 800px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            overflow: hidden;
            animation: fadeInUp 0.8s ease;
        }

        .card-header {
            background: linear-gradient(to left, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: bold;
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .card-header i {
            margin-right: 10px;
        }

        .complaint-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .complaint-item {
            padding: 1.5rem;
            margin: 15px;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: fadeIn 0.6s ease forwards;
            position: relative;
        }

        .complaint-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .complaint-item h5 {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .complaint-item p {
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #555;
        }

        .complaint-item strong {
            color: var(--dark-color);
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        .status-badge.bg-warning { background-color: var(--warning-color); color: #fff; }
        .status-badge.bg-success { background-color: var(--success-color); color: #fff; }
        .status-badge.bg-danger { background-color: var(--danger-color); color: #fff; }
        .status-badge.bg-secondary { background-color: #6c757d; color: #fff; }

        .admin-response {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #e9f5ff;
            border-left: 4px solid var(--info-color);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .admin-response strong {
            color: var(--info-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .no-response-message {
            color: #888;
            font-style: italic;
            margin-top: 1rem;
        }

        .rating-form {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .rating-form label {
            font-weight: 600;
            color: var(--dark-color);
        }

        .rating-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            margin-bottom: 1rem;
            background-color: #fff;
        }

        .rating-form button {
            background: linear-gradient(to left, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .rating-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .empty-message {
            text-align: center;
            color: #6c757d;
            padding: 2rem;
            font-size: 1.1rem;
            animation: fadeIn 1s ease;
        }

        .empty-message i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #adb5bd;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class='complaint-card animate__animated animate__fadeInUp'>
        <div class='card-header'>
            <h4 class='mb-0'><i class='bi bi-chat-dots'></i> شکایت‌های من</h4>
        </div>
        <div class='card-body'>
            @if($complaints->isEmpty())
                <div class='empty-message'>
                    <i class='bi bi-exclamation-circle'></i>
                    شما هیچ شکایتی ثبت نکرده‌اید.
                </div>
            @else
                <ul class='complaint-list'>
                    @foreach($complaints as $index => $complaint)
                        <li class='complaint-item animate__animated animate__fadeIn' style='animation-delay: {{ $index * 0.1 }}s;'>
                            <h5><i class='bi bi-pencil-fill' style='color: #ff6347;'></i> {{ $complaint->title }}</h5>
                            <p><i class='bi bi-file-earmark-text' style='color: #ffa500;'></i> {{ $complaint->description }}</p>
                            <p><strong><i class='bi bi-calendar-date' style='color: #4caf50;'></i> تاریخ ثبت:</strong> {{ jdate($complaint->created_at)->format('%A, %d %B %Y ساعت H:i') }}</p>
                            <p><strong><i class='bi bi-receipt' style='color: #2196f3;'></i> شماره سفارش:</strong> {{ $complaint->ordernumber }}</p>
                            <p>
                                امتیاز شکایت: {{ $complaint->rating ?? 'هنوز امتیازی ثبت نشده' }}
                                <br>
                                <strong><i class='bi bi-flag' style='color: #ffc107;'></i> وضعیت شکایت:</strong>
                                @switch($complaint->status)
                                    @case('in_progress')
                                        <span class='status-badge bg-warning'>
                                            <i class='bi bi-hourglass-split'></i> در حال بررسی
                                        </span>
                                        @break
                                    @case('answered')
                                        <span class='status-badge bg-success'>
                                            <i class='bi bi-check-circle'></i> پاسخ داده شده
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class='status-badge bg-danger'>
                                            <i class='bi bi-x-circle'></i> رد شده
                                        </span>
                                        @break
                                    @case('closed')
                                        <span class='status-badge bg-danger'>
                                            <i class='bi bi-x-circle'></i> بسته شده
                                        </span>
                                        @break
                                    @default
                                        <span class='status-badge bg-secondary'>
                                            <i class='bi bi-question-circle'></i> نامشخص
                                        </span>
                                @endswitch
                            </p>
                            @if($complaint->response)
                                <div class='admin-response'>
                                    <p class='mb-1'><strong><i class='bi bi-person-circle' style='color: #673ab7;'></i> پاسخ ادمین:</strong></p>
                                    <p class='text-success'>{{ $complaint->response->response }}</p>
                                </div>
                            @else
                                <p class='no-response-message'>پاسخی برای این شکایت ثبت نشده است.</p>
                            @endif

                            <!-- Form for submitting rating -->
                            @if($complaint->status === 'answered' && !$complaint->rating)
                                <form action='{{ route('complaint.rating', $complaint->id) }}' method='POST' class='rating-form'>
                                    @csrf
                                    <label for='rating'>امتیاز خود را وارد کنید:</label>
                                    <select name='rating' id='rating' class='form-select' required>
                                        <option value='1'>1 - ضعیف</option>
                                        <option value='2'>2 - متوسط</option>
                                        <option value='3'>3 - خوب</option>
                                        <option value='4'>4 - عالی</option>
                                        <option value='5'>5 - فوق‌العاده</option>
                                    </select>
                                    <button type='submit' class='btn btn-primary mt-3'>ارسال امتیاز</button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
