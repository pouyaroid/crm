<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>فرم ثبت شکایت</title>
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
            padding: 20px;
        }

        .main-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            animation: fadeInUp 0.8s ease;
        }

        .form-card {
            flex: 1 1 100%;
            max-width: 100%;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            overflow: hidden;
        }

        .dashboard {
            flex: 1 1 300px;
            max-width: 300px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease;
        }

        .card-header {
            background: linear-gradient(to left, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: bold;
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .dashboard .card-header {
            background: linear-gradient(to left, var(--info-color), #64b5f6);
            color: white;
            text-align: center;
            padding: 1rem;
        }

        .card-header i {
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        .form-control[type='file'] {
            padding: 10px;
        }

        .btn-success {
            background: linear-gradient(to left, var(--success-color), #66bb6a);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.5s ease;
        }

        .dashboard .list-group-item {
            border: none;
            padding: 1rem;
            text-align: center;
            transition: background-color 0.3s;
        }

        .dashboard .list-group-item:hover {
            background-color: #f1f3f5;
        }

        .dashboard a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .dashboard button {
            width: 100%;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .dashboard button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

        /* Responsive tweaks */
        @media (min-width: 992px) {
            .form-card {
                flex: 1 1 70%;
            }
            .dashboard {
                flex: 1 1 30%;
                max-width: 350px;
            }
        }

        @media (max-width: 991px) {
            .dashboard, .form-card {
                flex: 1 1 100%;
                max-width: 100%;
            }
            .dashboard {
                order: 1; /* در صفحات کوچک، داشبورد اول باشد */
            }
            .form-card {
                order: 2;
            }
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='main-container'>
            <!-- Dashboard Sidebar -->
            <div class='dashboard animate__animated animate__fadeIn'>
                <div class='card-header'>
                    <h5 class='card-title mb-0'>خوش آمدید، {{ auth()->user()->name }}!</h5>
                </div>
                <div class='card-body p-3'>
                    <h6 class='card-subtitle mb-3 text-muted text-center'>داشبورد</h6>
                    <ul class='list-group'>
                        <li class='list-group-item'>
                            <a href='{{ route('complaints.my') }}' class='text-decoration-none'>آمار شکایات</a>
                        </li>
                        <li class='list-group-item'>
                            <form method='POST' action='{{ route('logout') }}'>
                                @csrf
                                <button class='btn btn-outline-danger' type='submit'>خروج</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Form Card -->
            <div class='form-card animate__animated animate__fadeInUp'>
                <div class='card-header'>
                    <h4 class='mb-0'><i class='bi bi-chat-dots'></i> ثبت شکایت</h4>
                </div>
                <div class='card-body p-4'>
                    @if(session('success'))
                        <div class='alert alert-success alert-dismissible fade show text-center' role='alert'>
                            {{ session('success') }}
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class='alert alert-danger alert-dismissible fade show text-center' role='alert'>
                            {{ session('error') }}
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class='alert alert-warning alert-dismissible fade show text-start' role='alert'>
                            <ul class='mb-0'>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    @endif
                    <form method='POST' action='{{ route('complaints.store') }}' enctype='multipart/form-data'>
                        @csrf
                        <div class='form-group'>
                            <label for='ordernumber' class='form-label'><i class='bi bi-receipt'></i> شماره سفارش</label>
                            <input type='text' class='form-control' id='ordernumber' name='ordernumber' required value='{{ old('ordernumber') }}'>
                        </div>
                        <div class='form-group'>
                            <label for='title' class='form-label'><i class='bi bi-pencil-fill'></i> عنوان شکایت</label>
                            <input type='text' class='form-control' id='title' name='title' required value='{{ old('title') }}'>
                        </div>
                        <div class='form-group'>
                            <label for='description' class='form-label'><i class='bi bi-file-earmark-text'></i> توضیحات شکایت</label>
                            <textarea class='form-control' id='description' name='description' rows='4' required>{{ old('description') }}</textarea>
                        </div>
                        <div class='form-group'>
                            <label for='images' class='form-label'><i class='bi bi-images'></i> ارسال تصاویر (می‌توانید چند عکس انتخاب کنید)</label>
                            <input type='file' class='form-control' id='images' name='images[]' accept='image/*' multiple>
                        </div>
                        <div class='form-group'>
                            <label for='video' class='form-label'><i class='bi bi-camera-video'></i> ارسال ویدیو (اختیاری)</label>
                            <input type='file' class='form-control' id='video' name='video' accept='video/*'>
                        </div>
                        <button type='submit' class='btn-success'>
                            <i class='bi bi-send-check'></i> ارسال شکایت
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
