<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ویرایش تسک</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- Persian Datepicker CSS -->
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker/dist/css/persian-datepicker.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        @import url('https://cdn.fontcdn.ir/Font/Persian/Vazir/Vazir.css');

        body {
            font-family: 'Vazir', sans-serif !important;
            direction: rtl;
            background-color: #e0f2f7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .form-container {
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(5px);
            width: 100%;
            max-width: 700px;
        }

        .form-container:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .form-label {
            font-weight: 700;
            color: #34495e;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control,
        .form-select {
            border-radius: 0.75rem;
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .btn-custom {
            padding: 0.8rem 2rem;
            font-weight: 700;
            font-size: 1.05rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            background-image: linear-gradient(45deg, #28a745 0%, #218838 100%);
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
            background-image: linear-gradient(45deg, #218838 0%, #1e7e34 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            background-image: linear-gradient(45deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            background-image: linear-gradient(45deg, #5a6268 0%, #4e555b 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .alert-danger {
            border-radius: 0.75rem;
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            padding: 1rem 1.5rem;
            margin-top: 1.5rem;
        }

        .alert-danger ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-danger li {
            margin-bottom: 0.5rem;
        }

        .alert-danger li:last-child {
            margin-bottom: 0;
        }

        .form-select:disabled {
            background-color: #e9ecef;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-label {
            cursor: pointer;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="form-container text-end">
        <h3 class="mb-4 text-center">ویرایش تسک</h3>

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('todos.update', $todo->id) }}">
            @csrf
            @method('PUT') {{-- متد PUT برای عملیات ویرایش --}}

            <div class="mb-3">
                <label for="title" class="form-label">عنوان تسک <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $todo->title) }}" required placeholder="مثلاً: پیگیری ایمیل مشتری" />
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea name="description" class="form-control" rows="4" placeholder="توضیحات کامل درباره تسک بنویسید...">{{ old('description', $todo->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="due_date_picker" class="form-label">تاریخ و ساعت مهلت</label>
                <!-- فیلد نمایش Datepicker -->
                <input type="text" 
                       id="due_date_picker" 
                       class="form-control" 
                       placeholder="برای انتخاب تاریخ و ساعت کلیک کنید" 
                       autocomplete="off"
                       data-alt-field="#due_date_gregorian" {{-- این به Datepicker میگه خروجی رو کجا بذاره --}}
                       data-alt-format="YYYY-MM-DD HH:mm:ss" {{-- این به Datepicker میگه خروجی با چه فرمتی باشه --}}
                />
                <!-- فیلد مخفی که تاریخ میلادی با ارقام انگلیسی را نگه می‌دارد و به کنترلر ارسال می‌شود -->
                <input type="hidden" name="due_date" id="due_date_gregorian" value="{{ old('due_date', $todo->due_date) }}" />
            </div>

            {{-- نمایش فیلد انتخاب کاربر فقط برای ادمین و سرپرست --}}
            @if(Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('supervisor')))
                <div class="mb-3">
                    <label for="user_id" class="form-label">انتخاب کاربر <span class="text-danger">*</span></label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">کاربر مورد نظر را انتخاب کنید</option>
                        {{-- $users باید از کنترلر به این ویو ارسال شود --}}
                        @foreach($users as $userOption) {{-- نام متغیر را تغییر دادم تا با $user فعلی تداخل نداشته باشد --}}
                            <option value="{{ $userOption->id }}" {{ old('user_id', $todo->user_id) == $userOption->id ? 'selected' : '' }}>
                                {{ $userOption->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            @else
                {{-- برای کاربران عادی، user_id به طور خودکار از $todo->user_id گرفته می‌شود --}}
                <input type="hidden" name="user_id" value="{{ $todo->user_id }}">
            @endif

            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" name="is_done" id="is_done" value="1" {{ old('is_done', $todo->is_done) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_done">انجام شده</label>
            </div>

            <div class="d-flex gap-2 mt-4 justify-content-end flex-wrap">
                <a href="{{ route('todos.index') }}" class="btn btn-secondary btn-custom">بازگشت</a>
                <button type="submit" class="btn btn-success btn-custom">ذخیره تغییرات</button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <!-- ترتیب بارگذاری اسکریپت‌ها بسیار مهم است: jQuery -> persian-date -> persian-datepicker -> Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker/dist/js/persian-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function () {
            // تابع کمکی برای تبدیل ارقام فارسی به انگلیسی
            function convertPersianToEnglishDigits(str) {
                if (!str) return str; 
                const persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                return str.replace(/[۰-۹]/g, d => persianDigits.indexOf(d));
            }

            // تعیین مقدار اولیه برای Datepicker
            let initialGregorianDateString = null; // این رشته میلادی با ارقام انگلیسی خواهد بود
            let initialPersianDateStringForDisplay = ''; // این رشته شمسی برای نمایش در فیلد اصلی خواهد بود

            // 1. بررسی old('due_date') - در صورت ریدایرکت یا خطا
            @if(old('due_date'))
                initialGregorianDateString = convertPersianToEnglishDigits("{{ old('due_date') }}");
            // 2. بررسی $todo->due_date - تاریخ موجود در تسک برای ویرایش
            @elseif(isset($todo) && $todo->due_date)
                // $todo->due_date از دیتابیس میاد و باید میلادی باشه، فقط ارقامش رو انگلیسی میکنیم
                initialGregorianDateString = convertPersianToEnglishDigits("{{ $todo->due_date }}");
            @endif

            // اگر یک مقدار اولیه میلادی معتبر داریم
            if (initialGregorianDateString) {
                try {
                    let dateObj = new Date(initialGregorianDateString);
                    if (!isNaN(dateObj.getTime())) { 
                        initialPersianDateStringForDisplay = new persianDate(dateObj).format('YYYY/MM/DD HH:mm:ss');
                        $('#due_date_gregorian').val(initialGregorianDateString);
                    } else {
                        // اگر تاریخ نامعتبر بود، به زمان فعلی برگرد
                        initialGregorianDateString = null; 
                    }
                } catch (e) {
                    console.error("خطا در پردازش تاریخ اولیه (try-catch):", e);
                    initialGregorianDateString = null;
                }
            }

            // اگر هیچ مقدار اولیه‌ای از old یا $todo وجود نداشت یا نامعتبر بود، زمان فعلی را ست میکنیم
            if (!initialGregorianDateString) {
                let now = new Date();
                let year = now.getFullYear();
                let month = String(now.getMonth() + 1).padStart(2, '0');
                let day = String(now.getDate()).padStart(2, '0');
                let hours = String(now.getHours()).padStart(2, '0');
                let minutes = String(now.getMinutes()).padStart(2, '0');
                let seconds = String(now.getSeconds()).padStart(2, '0');
                
                initialGregorianDateString = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                initialPersianDateStringForDisplay = new persianDate(now).format('YYYY/MM/DD HH:mm:ss');
                $('#due_date_gregorian').val(initialGregorianDateString);
            }

            // راه‌اندازی Datepicker
            var pdatePicker = $('#due_date_picker').pDatepicker({
                format: 'YYYY/MM/DD HH:mm:ss', // فرمت نمایشی برای کاربر
                calendarType: 'persian',
                // altField و altFormat را از data attributes می‌خواند
                timePicker: {
                    enabled: true,
                    meridiem: { enabled: true },
                    second: { enabled: true }
                },
                autoClose: true,
                observer: true,
                // formatter: این تابع تضمین می‌کند که خروجی altField همیشه میلادی با ارقام انگلیسی باشد.
                formatter: function(unix, values, calendar) {
                    let gregorianDate = new Date(unix); 
                    let year = gregorianDate.getFullYear();
                    let month = String(gregorianDate.getMonth() + 1).padStart(2, '0');
                    let day = String(gregorianDate.getDate()).padStart(2, '0');
                    let hours = String(gregorianDate.getHours()).padStart(2, '0');
                    let minutes = String(gregorianDate.getMinutes()).padStart(2, '0');
                    let seconds = String(gregorianDate.getSeconds()).padStart(2, '0');
                    
                    let formattedGregorian = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    
                    $('#due_date_gregorian').val(formattedGregorian); // ذخیره در فیلد مخفی

                    let persianDateInstance = new persianDate(unix);
                    return persianDateInstance.format('YYYY/MM/DD HH:mm:ss'); // فرمت شمسی برای نمایش در input
                }
            });

            // مقداردهی نهایی فیلد نمایشی پس از اتمام بارگذاری datepicker
            $('#due_date_picker').val(initialPersianDateStringForDisplay);


            // بخش مربوط به انتخاب کاربر (فقط برای ادمین و سرپرست)
            // این منطق در کنترلر edit($id) هم باید مطمئن بشه که $users ارسال میشه
            const userIdSelect = $('#user_id');
            const currentUserRoleId = "{{ Auth::check() ? Auth::user()->roles->first()->id : '' }}"; // فرض می‌کنیم نقش‌ها id دارند
            
            // اگر کاربر ادمین یا سرپرست نیست، فیلد user_id رو غیرفعال و مخفی کن
            @if(!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('supervisor'))
                if(userIdSelect.length) {
                    userIdSelect.prop('disabled', true).hide().removeAttr('required');
                    // اگر فیلد مخفی user_id رو در بالا ست کردیم، اینجا نیازی نیست
                }
            @endif
        });
    </script>
</body>
</html>