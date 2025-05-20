@extends('layouts.app')
@section('title','مشاهده کاربران')
@section('content')
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>لیست کاربران</title>
    
    <!-- Bootstrap 5 RTL CSS از CDN -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    
    <!-- فونت فارسی Vazir از Google Fonts -->
    <link href='https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;700&display=swap' rel='stylesheet'>
    
    <!-- آیکون‌ها از Bootstrap Icons -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
    
    <!-- CSS سفارشی برای زیبایی و انیمیشن -->
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef); /* گرادیان نرم برای جذابیت */
            min-height: 100vh; /* پوشش کامل ارتفاع صفحه */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 1200px; /* عرض حداکثری برای تمرکز */
            margin-top: 20px; /* فاصله از بالا */
        }
        h1 {
            text-align: center;
            color: #343a40; /* رنگ تیره برای عنوان */
            margin-bottom: 30px;
            font-weight: 700; /* وزن فونت سنگین برای برجسته‌سازی */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* سایه نرم برای عمق */
        }
        .search-bar {
            margin-bottom: 30px; /* فاصله از لیست */
            display: flex;
            justify-content: center;
        }
        .search-input {
            max-width: 400px; /* عرض محدود برای تمرکز */
            border-radius: 50px; /* گوشه‌های گرد برای زیبایی */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* سایه ملایم */
        }
        .card {
            transition: all 0.3s ease; /* انیمیشن برای hover */
            border-radius: 15px; /* گوشه‌های گردتر */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* سایه برای عمق */
            margin-bottom: 20px; /* فاصله بین کارت‌ها */
        }
        .card:hover {
            transform: translateY(-5px); /* حرکت کمی به بالا در hover */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); /* سایه قوی‌تر در hover */
        }
        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 150px; /* ارتفاع ثابت برای تصاویر */
            object-fit: cover; /* پوشش کامل تصویر بدون اعوجاج */
        }
        .card-title {
            font-weight: 600; /* وزن فونت برای نام کاربر */
            color: #007bff; /* رنگ آبی برای جذابیت */
        }
        .card-text {
            color: #495057; /* رنگ خاکستری برای متن */
        }
        .btn-group {
            justify-content: center; /* مرکز کردن دکمه‌ها */
        }
        .btn {
            transition: all 0.3s ease; /* انیمیشن برای دکمه‌ها */
        }
        .btn:hover {
            transform: scale(1.05); /* بزرگ شدن کمی در hover */
        }
        /* انیمیشن fade-in برای کارت‌ها */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card {
            animation: fadeIn 0.5s ease-out;
        }
        /* پیام زمانی که لیست خالی است */
        .no-users {
            text-align: center;
            color: #6c757d;
            font-size: 1.2em;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class='container'>
        <h1>لیست کاربران</h1>
        
        <!-- نوار جستجو -->
        <div class='search-bar'>
            <form action='{{ route('users.index') }}' method='GET' class='w-100'>
                <div class='input-group search-input'>
                    <input type='text' name='search' class='form-control' placeholder='جستجوی کاربر...' aria-label='Search' value='{{ request("search") }}'>
                    <button class='btn btn-primary' type='submit'><i class='bi bi-search'></i></button>
                </div>
            </form>
        </div>
        
        <!-- لیست کاربران به صورت کارت‌ها -->
        <div class='row'>
            @forelse($users as $user)
                <div class='col-md-4 col-sm-6 mb-4'> <!-- پاسخگو برای دسکتاپ و موبایل -->
                    <div class='card'>
                        <!-- تصویر تصادفی یا آیکون (می‌توانید با عکس واقعی جایگزین کنید) -->
                        {{-- <img src='https://via.placeholder.com/300x150?text={{ urlencode($user->name) }}' class='card-img-top' alt='{{ $user->name }}'> --}}
                        <div class='card-body'>
                            <h5 class='card-title'>{{ $user->name }}</h5>
                            <p class='card-text'>ایمیل: {{ $user->email }}</p>
                            <!-- دکمه‌های عملیاتی (ویرایش و حذف، فرض بر اینکه روت‌ها وجود دارند) -->
                            <div class='btn-group' role='group'>
                                {{-- <a href='{{ route('users.edit', $user->id) }}' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i> ویرایش</a>
                                {{-- <form action='{{ route('users.destroy', $user->id) }}' method='POST' style='display:inline;'>
                                    @csrf
                                    @method('DELETE')
                                    <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm('آیا مطمئن هستید؟')'><i class='bi bi-trash'></i> حذف</button>
                                </form> --}} 
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class='col-12'>
                    <p class='no-users'>هیچ کاربری یافت نشد. یک کاربر جدید ایجاد کنید!</p>
                </div>
            @endforelse
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
            
        </div>
    </div>

    <!-- اسکریپت Bootstrap -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
@endsection
