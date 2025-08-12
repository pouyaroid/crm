<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>افزودن تسک جدید</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker/dist/css/persian-datepicker.min.css" />
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
            border: 1px solid rgba(255, 255, 255, 0.6);
            width: 100%;
            max-width: 700px;
        }
        .form-label { font-weight: 700; color: #34495e; margin-bottom: 0.5rem; }
        .form-control, .form-select { border-radius: 0.75rem; padding: 0.75rem 1rem; }
        .btn-custom { padding: 0.8rem 2rem; font-weight: 700; border-radius: 0.75rem; }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="form-container text-end">
            <h3 class="mb-4 text-center">افزودن تسک جدید</h3>

            @if($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('todos.store') }}" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">عنوان تسک <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="مثلاً: پیگیری ایمیل مشتری" />
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">توضیحات</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="توضیحات کامل">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="due_date_picker" class="form-label">تاریخ و ساعت مهلت</label>
                    <input type="text" id="due_date_picker" class="form-control" placeholder="برای انتخاب تاریخ کلیک کنید"
                           autocomplete="off" data-alt-field="#due_date_gregorian"
                           data-alt-format="YYYY-MM-DD HH:mm:ss" />
                    <input type="hidden" name="due_date" id="due_date_gregorian" value="{{ old('due_date') }}" />
                </div>

                @if(Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('supervisor')))
                    <div class="mb-3">
                        <label for="user_id" class="form-label">انتخاب کاربر <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">کاربر مورد نظر را انتخاب کنید</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                @endif

                <div class="d-flex gap-2 mt-4 justify-content-end flex-wrap">
                    <a href="{{ route('todos.index') }}" class="btn btn-secondary btn-custom">بازگشت</a>
                    <button type="submit" class="btn btn-success btn-custom">ذخیره تسک</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker/dist/js/persian-datepicker.min.js"></script>

    <script>
        $(document).ready(function () {
            function convertPersianToEnglishDigits(str) {
                if (!str) return str;
                const persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
                return str.replace(/[۰-۹]/g, d => persianDigits.indexOf(d));
            }

            let initialGregorianDateString = null;
            let initialPersianDateStringForDisplay = '';

            @if(old('due_date'))
                initialGregorianDateString = convertPersianToEnglishDigits("{{ old('due_date') }}");
            @elseif(isset($todo) && $todo->due_date)
                initialGregorianDateString = convertPersianToEnglishDigits("{{ $todo->due_date }}");
            @endif

            if (initialGregorianDateString) {
                let dateObj = new Date(initialGregorianDateString);
                if (!isNaN(dateObj.getTime())) {
                    initialPersianDateStringForDisplay = new persianDate(dateObj).format('YYYY/MM/DD HH:mm:ss');
                    $('#due_date_gregorian').val(initialGregorianDateString);
                } else {
                    initialGregorianDateString = null;
                }
            }

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

            var pdatePicker = $('#due_date_picker').pDatepicker({
                format: 'YYYY/MM/DD HH:mm:ss',
                calendar: {
                    persian: {
                        locale: 'fa',
                        leapYearMode: 'astronomical' // ✅ اضافه شد برای سال کبیسه
                    }
                },
                calendarType: 'persian',
                timePicker: {
                    enabled: true,
                    meridiem: { enabled: true },
                    second: { enabled: true }
                },
                autoClose: true,
                observer: true,
                formatter: function(unix) {
                    let gregorianDate = new Date(unix);
                    let formattedGregorian = `${gregorianDate.getFullYear()}-${String(gregorianDate.getMonth()+1).padStart(2,'0')}-${String(gregorianDate.getDate()).padStart(2,'0')} ${String(gregorianDate.getHours()).padStart(2,'0')}:${String(gregorianDate.getMinutes()).padStart(2,'0')}:${String(gregorianDate.getSeconds()).padStart(2,'0')}`;
                    $('#due_date_gregorian').val(formattedGregorian);
                    return new persianDate(unix).format('YYYY/MM/DD HH:mm:ss');
                }
            });

            $('#due_date_picker').val(initialPersianDateStringForDisplay);
        });
    </script>
</body>
</html>
