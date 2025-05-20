@extends('layouts.app')
@section('title','مشاهده شکایات')
@section('content')
    <title>پنل ادمین - شکایت‌ها</title>
    
    <!-- استایل‌های اصلی -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel='stylesheet'>
    <link href='https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css' rel='stylesheet'>
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
            color: #333;
            padding: 20px;
        }

        .navbar {
            background: linear-gradient(to left, var(--primary-color), var(--secondary-color));
            animation: fadeInDown 0.8s ease;
        }

        .navbar-brand, .nav-link {
            font-weight: 600;
        }

        .container {
            max-width: 1200px;
            animation: fadeIn 0.6s ease;
        }

        .filter-form {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .complaint-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .complaint-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.6rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .card-text strong {
            color: var(--dark-color);
            font-weight: 600;
        }

        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-gallery img {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .image-gallery img:hover {
            transform: scale(1.05);
        }

        .video-container video {
            width: 100%;
            border-radius: 8px;
        }

        .status-badge {
            font-size: 1rem;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert {
            border-radius: 8px;
            font-size: 1.1rem;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a, .page-item.active .page-link {
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a:hover {
            background-color: #e9ecef;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            .filter-form .row > * {
                margin-bottom: 10px;
            }
            .complaint-card {
                padding: 15px;
            }
            .image-gallery img {
                max-width: 100px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- نوار ناوبری -->
<nav class='navbar navbar-expand-lg navbar-dark shadow-sm mb-4'>
    <div class='container-fluid'>
        <a class='navbar-brand' href='#'>
            <i class='fas fa-cogs'></i> پنل ادمین
        </a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav ms-auto'>
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route('complaints.index') }}'>لیست شکایت‌ها</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='{{ route('logout') }}' onclick='event.preventDefault(); document.getElementById('logout-form').submit();'>
                        خروج
                    </a>
                    <form id='logout-form' action='{{ route('logout') }}' method='POST' class='d-none'>
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class='container animate__animated animate__fadeIn'>
    <h2 class='mb-4 text-center text-primary'>پنل مدیریت شکایت‌ها</h2>

    <!-- فرم فیلتر -->
    <div class='filter-form'>
        <form method='GET' action='{{ route('complaints.index') }}' class='row g-3'>
            <div class='col-md-3'>
                <input type='text' name='title' class='form-control' placeholder='جستجو بر اساس عنوان' value='{{ request('title') }}'>
            </div>
            <div class='col-md-3'>
                <input type='text' name='ordernumber' class='form-control' placeholder='شماره سفارش' value='{{ request('ordernumber') }}'>
            </div>
            <div class='col-md-3'>
                <input type='text' name='user' class='form-control' placeholder='نام کاربر' value='{{ request('user') }}'>
            </div>
            <div class='col-md-3'>
                <input type='date' name='date' class='form-control' value='{{ request('date') }}'>
            </div>
            <div class='col-12 text-center'>
                <button type='submit' class='btn btn-primary px-4 me-2'>
                    <i class='fas fa-search'></i> جستجو
                </button>
                <a href='{{ route('complaints.index') }}' class='btn btn-secondary'>
                    <i class='fas fa-times-circle'></i> حذف فیلتر
                </a>
            </div>
        </form>
    </div>

    <!-- پیام موفقیت -->
    @if(session('success'))
        <div class='alert alert-success text-center animate__animated animate__fadeIn'>
            <i class='fas fa-check-circle'></i> {{ session('success') }}
        </div>
    @endif

    <!-- لیست شکایت‌ها -->
    @forelse($complaints as $complaint)
        <div class='complaint-card'>
            <h5 class='card-title'>{{ $complaint->title }}</h5>

            <p class='card-text'><strong>نام کاربر:</strong> {{ $complaint->user->name ?? 'ناشناس' }} <i class='fas fa-user-circle'></i></p>
            <p class='card-text'><strong>شناسه کاربر:</strong> {{ $complaint->user->id ?? '-' }} <i class='fas fa-id-badge'></i></p>
            <p class='card-text'><strong>شماره سفارش:</strong> {{ $complaint->ordernumber ?? '-' }} <i class='fas fa-hashtag'></i></p>
            <p class='card-text'><strong>توضیحات:</strong> {{ $complaint->description }} <i class='fas fa-clipboard-list'></i></p>
            <p class='card-text'><strong>تاریخ ثبت شکایت:</strong> {{ jdate($complaint->created_at)->format('Y/m/d H:i') }} <i class='fas fa-calendar-day'></i></p>

            @if($complaint->images->count())
                <div class='card-text'>
                    <strong>تصاویر:</strong><br>
                    <div class='d-flex flex-wrap gap-2 image-gallery'>
                        @foreach($complaint->images as $image)
                            <a href='{{ asset('storage/' . $image->path) }}' data-lightbox='gallery-{{ $complaint->id }}'>
                                <img src='{{ asset('storage/' . $image->path) }}' class='img-thumbnail' alt='تصویر شکایت'>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($complaint->video_path)
                <div class='card-text video-container'>
                    <strong>ویدیو:</strong><br>
                    <video controls style='max-width: 100%; border-radius: 8px;'>
                        <source src='{{ asset('storage/' . $complaint->video_path) }}' type='video/mp4'>
                        مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                    </video>
                </div>
            @endif

            <!-- نمایش پاسخ -->
            <div class='card-text mt-3'>
                @if ($complaint->response)
                    <div class='alert alert-success'>
                        <strong>پاسخ ادمین:</strong> {{ $complaint->response->message }} <i class='fas fa-reply-all'></i>
                    </div>
                @else
                    <form method='POST' action='{{ route('complaints.response.store', $complaint->id) }}' class='mt-3'>
                        @csrf
                        <div class='mb-3'>
                            <label for='response-{{ $complaint->id }}' class='form-label'>پاسخ به شکایت</label>
                            <textarea name='response' id='response-{{ $complaint->id }}' class='form-control' rows='4' required></textarea>
                        </div>
                        <button type='submit' class='btn btn-success'>
                            <i class='fas fa-paper-plane'></i> ثبت پاسخ
                        </button>
                    </form>
                @endif
            </div>

            <!-- نمایش وضعیت و فرم تغییر -->
            <div class='card-text mt-3'>
                <p><strong>وضعیت شکایت:</strong>
                    <span class='status-badge badge bg-info'>{{ $complaint->status_fa }}</span>
                </p>
                <form method='POST' action='{{ route('complaints.update.status', $complaint->id) }}' class='mt-2'>
                    @csrf
                    @method('PUT')
                    <div class='input-group'>
                        <select name='status' class='form-select' required>
                            <option value=''>تغییر وضعیت</option>
                            <option value='in_progress' {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>در حال بررسی</option>
                            <option value='answered' {{ $complaint->status == 'answered' ? 'selected' : '' }}>پاسخ داده شد</option>
                            <option value='closed' {{ $complaint->status == 'closed' ? 'selected' : '' }}>بسته شده</option>
                            <option value='rejected' {{ $complaint->status == 'rejected' ? 'selected' : '' }}>رد شده</option>
                        </select>
                        <button type='submit' class='btn btn-outline-primary ms-2'>ثبت</button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class='alert alert-info text-center animate__animated animate__fadeIn'>
            <i class='fas fa-info-circle'></i> هیچ شکایتی ثبت نشده است.
        </div>
    @endforelse

    <!-- صفحه‌بندی -->
    @if ($complaints->hasPages())
        <div class='pagination mt-4'>
            {{ $complaints->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
@endsection
