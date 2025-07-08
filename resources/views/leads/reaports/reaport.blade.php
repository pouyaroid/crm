@extends('layouts.app')

@section('title', 'گزارش سرنخ ها')

@section('content')
{{-- اضافه کردن CDN برای Persian Datepicker CSS --}}
<link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
<style>
    body { font-family: 'Vazirmatn', sans-serif; direction: rtl; background-color: #f8f9fa; }
    .custom-date-inputs { display: flex; gap: 1rem; }
    /* استایل دهی اضافی برای فیلدهای Datepicker */
    .pdp-default {
        z-index: 9999 !important; /* اطمینان از نمایش بالای عناصر دیگر */
    }
</style>

<div class="container mt-5">
    <h3 class="mb-4 fw-bold">📊 گزارش‌گیری از مشتریان احتمالی</h3>

    {{-- فرم فیلتر بازه زمانی --}}
    <form method="GET" action="{{ route('leads.report') }}" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label class="form-label">بازه زمانی</label>
            <select name="range" class="form-select" onchange="toggleDateInputs(this.value)">
                <option value="">انتخاب کنید</option>
                <option value="7days" {{ request('range') == '7days' ? 'selected' : '' }}>هفت روز گذشته</option>
                <option value="1month" {{ request('range') == '1month' ? 'selected' : '' }}>یک ماه گذشته</option>
                <option value="1year" {{ request('range') == '1year' ? 'selected' : '' }}>یک سال گذشته</option>
                <option value="custom" {{ request('range') == 'custom' ? 'selected' : '' }}>بازه دلخواه</option>
            </select>
        </div>

        <div class="col-md-6" id="custom-dates-wrapper" style="{{ request('range') == 'custom' ? '' : 'display:none' }}">
            <label class="form-label">از تاریخ تا تاریخ (شمسی)</label>
            <div class="custom-date-inputs">
                {{-- فیلد ورودی نمایش تاریخ شمسی "از تاریخ" --}}
                <input type="text" id="from_date_jalali" class="form-control" placeholder="از تاریخ">
                {{-- فیلد پنهان برای ارسال تاریخ میلادی "از تاریخ" به سرور --}}
                <input type="hidden" name="from" id="from_date_gregorian" value="{{ request('from') }}">

                {{-- فیلد ورودی نمایش تاریخ شمسی "تا تاریخ" --}}
                <input type="text" id="to_date_jalali" class="form-control" placeholder="تا تاریخ">
                {{-- فیلد پنهان برای ارسال تاریخ میلادی "تا تاریخ" به سرور --}}
                <input type="hidden" name="to" id="to_date_gregorian" value="{{ request('to') }}">
            </div>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">مشاهده گزارش</button>
        </div>
    </form>

    {{-- جدول لیدها --}}
    @if($leads->count())
        <div class="table-responsive mb-5">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>نام</th>
                        <th>تلفن</th>
                        <th>شرکت</th>
                        <th>منبع</th>
                        <th>سطح علاقه</th>
                        <th>وضعیت</th>
                        <th>تاریخ ثبت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                        <tr>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->company }}</td>
                            <td>{{ $lead->source }}</td>
                            <td>{{ $lead->interest_level }}</td>
                            <td>{{ $lead->status }}</td>
                            {{-- نمایش تاریخ ثبت به صورت شمسی --}}
                            <td>{{ jdate($lead->created_at)->format('Y/m/d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- نمودار --}}
        <div class="mb-5">
            <h5 class="mb-3">📈 نمودار روند ثبت لیدها</h5>
            <canvas id="leadChart" height="120"></canvas>
        </div>
    @else
        <div class="alert alert-warning text-center">هیچ اطلاعاتی برای این بازه زمانی یافت نشد.</div>
    @endif
</div>

{{-- اسکریپت‌های مورد نیاز برای jQuery, Persian Datepicker و Chart.js --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // تابع برای نمایش/پنهان کردن فیلدهای تاریخ دلخواه
    function toggleDateInputs(value) {
        const customDatesWrapper = document.getElementById('custom-dates-wrapper');
        customDatesWrapper.style.display = (value === 'custom') ? 'flex' : 'none';
        // وقتی به بازه دلخواه می‌رویم و فیلدها مخفی بودند، مقادیر آنها را خالی می‌کنیم تا در بارگذاری مجدد صفحه مشکل پیش نیاید.
        if (value !== 'custom') {
            $('#from_date_jalali').val('');
            $('#from_date_gregorian').val('');
            $('#to_date_jalali').val('');
            $('#to_date_gregorian').val('');
        }
    }

    $(document).ready(function() {
        // فعال کردن Persian Datepicker برای "از تاریخ"
        $("#from_date_jalali").pDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            altField: '#from_date_gregorian', // تاریخ میلادی در این فیلد ذخیره می‌شود
            altFormat: 'YYYY-MM-DD', // فرمت میلادی
            observer: true,
            calendar: {
                persian: {
                    locale: 'fa'
                }
            },
            initialValue: true, // اطمینان از اینکه Datepicker مقدار اولیه را از altField بگیرد
            onSelect: function(unix) {
                // می‌توانید اینجا هر عملیات اضافی پس از انتخاب تاریخ انجام دهید
            }
        });

        // فعال کردن Persian Datepicker برای "تا تاریخ"
        $("#to_date_jalali").pDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            altField: '#to_date_gregorian', // تاریخ میلادی در این فیلد ذخیره می‌شود
            altFormat: 'YYYY-MM-DD', // فرمت میلادی
            observer: true,
            calendar: {
                persian: {
                    locale: 'fa'
                }
            },
            initialValue: true, // اطمینان از اینکه Datepicker مقدار اولیه را از altField بگیرد
            onSelect: function(unix) {
                // می‌توانید اینجا هر عملیات اضافی پس از انتخاب تاریخ انجام دهید
            }
        });

        // مدیریت مقدار اولیه Datepickerها در صورت وجود مقادیر old/request در فیلدهای hidden
        // این بخش اطمینان می‌دهد که اگر کاربر فرم را سابمیت کرده و خطایی رخ داده،
        // یا در حال ویرایش است، تاریخ شمسی صحیح در Datepicker نمایش داده شود.
        const initialFromGregorian = $('#from_date_gregorian').val();
        if (initialFromGregorian) {
            const pdate = new persianDate(new Date(initialFromGregorian));
            $("#from_date_jalali").pDatepicker("setDate", pdate);
        }

        const initialToGregorian = $('#to_date_gregorian').val();
        if (initialToGregorian) {
            const pdate = new persianDate(new Date(initialToGregorian));
            $("#to_date_jalali").pDatepicker("setDate", pdate);
        }

        // فراخوانی اولیه برای تنظیم وضعیت نمایش فیلدهای تاریخ دلخواه بر اساس مقدار range
        toggleDateInputs($('select[name="range"]').val());


        // --- منطق نمودار Chart.js ---
        const ctx = document.getElementById('leadChart')?.getContext('2d');
        @if(!empty($chartData['labels']) && !empty($chartData['data']))
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [{
                    label: 'تعداد لیدها',
                    data: {!! json_encode($chartData['data']) !!},
                    backgroundColor: 'rgba(13, 110, 253, 0.2)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Vazirmatn' // برای فارسی کردن فونت legend
                            }
                        }
                    },
                    tooltip: {
                        rtl: true, // برای نمایش تولتیپ راست به چپ
                        bodyFont: {
                            family: 'Vazirmatn'
                        },
                        titleFont: {
                            family: 'Vazirmatn'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                family: 'Vazirmatn' // برای فارسی کردن فونت محور X
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Vazirmatn' // برای فارسی کردن فونت محور Y
                            }
                        }
                    }
                }
            }
        });
        @endif
    });
</script>
@endsection