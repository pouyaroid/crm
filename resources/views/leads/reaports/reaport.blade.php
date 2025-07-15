@extends('layouts.app')

@section('title', 'گزارش سرنخ ها')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

<style>
    body {
        font-family: 'Vazirmatn', sans-serif;
        direction: rtl;
        background-color: #f8f9fa;
    }

    .custom-date-inputs {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .pdp-default {
        z-index: 9999 !important;
    }

    @media (max-width: 768px) {
        .custom-date-inputs {
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label,
        .form-select,
        .form-control,
        .btn {
            font-size: 14px;
        }

        h3 {
            font-size: 18px;
            text-align: center;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table thead {
            display: none;
        }

        table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            padding: 1rem;
            background-color: #fff;
            border-radius: 8px;
        }

        table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border: none;
            font-size: 14px;
        }

        table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            color: #333;
        }
    }
</style>

<div class="container mt-4 mb-5">
    <h3 class="mb-4 fw-bold">📊 گزارش‌گیری از مشتریان احتمالی</h3>

    <form method="GET" action="{{ route('leads.report') }}" class="row gy-3 align-items-end mb-4">
        <div class="col-12 col-md-3">
            <label class="form-label">بازه زمانی</label>
            <select name="range" class="form-select" onchange="toggleDateInputs(this.value)">
                <option value="">انتخاب کنید</option>
                <option value="7days" {{ request('range') == '7days' ? 'selected' : '' }}>هفت روز گذشته</option>
                <option value="1month" {{ request('range') == '1month' ? 'selected' : '' }}>یک ماه گذشته</option>
                <option value="1year" {{ request('range') == '1year' ? 'selected' : '' }}>یک سال گذشته</option>
                <option value="custom" {{ request('range') == 'custom' ? 'selected' : '' }}>بازه دلخواه</option>
            </select>
        </div>

        <div class="col-12 col-md-6" id="custom-dates-wrapper" style="{{ request('range') == 'custom' ? '' : 'display:none' }}">
            <label class="form-label">از تاریخ تا تاریخ (شمسی)</label>
            <div class="custom-date-inputs">
                <input type="text" id="from_date_jalali" class="form-control" placeholder="از تاریخ">
                <input type="hidden" name="from" id="from_date_gregorian" value="{{ request('from') }}">
                <input type="text" id="to_date_jalali" class="form-control" placeholder="تا تاریخ">
                <input type="hidden" name="to" id="to_date_gregorian" value="{{ request('to') }}">
            </div>
        </div>

        <div class="col-12 col-md-2">
            <button type="submit" class="btn btn-primary w-100">مشاهده گزارش</button>
        </div>
    </form>

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
                            <td data-label="نام">{{ $lead->name }}</td>
                            <td data-label="تلفن">{{ $lead->phone }}</td>
                            <td data-label="شرکت">{{ $lead->company }}</td>
                            <td data-label="منبع">{{ $lead->source }}</td>
                            <td data-label="سطح علاقه">{{ $lead->interest_level }}</td>
                            <td data-label="وضعیت">{{ $lead->status }}</td>
                            <td data-label="تاریخ ثبت">{{ jdate($lead->created_at)->format('Y/m/d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mb-5">
            <h5 class="mb-3">📈 نمودار روند ثبت لیدها</h5>
            <canvas id="leadChart" height="120"></canvas>
        </div>
    @else
        <div class="alert alert-warning text-center">هیچ اطلاعاتی برای این بازه زمانی یافت نشد.</div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function toggleDateInputs(value) {
        const wrapper = document.getElementById('custom-dates-wrapper');
        wrapper.style.display = (value === 'custom') ? 'block' : 'none';
        if (value !== 'custom') {
            $('#from_date_jalali').val('');
            $('#from_date_gregorian').val('');
            $('#to_date_jalali').val('');
            $('#to_date_gregorian').val('');
        }
    }

    $(document).ready(function () {
        $("#from_date_jalali").pDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            altField: '#from_date_gregorian',
            altFormat: 'YYYY-MM-DD',
            observer: true,
            calendar: { persian: { locale: 'fa' } },
            initialValue: true
        });

        $("#to_date_jalali").pDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            altField: '#to_date_gregorian',
            altFormat: 'YYYY-MM-DD',
            observer: true,
            calendar: { persian: { locale: 'fa' } },
            initialValue: true
        });

        const initialFrom = $('#from_date_gregorian').val();
        if (initialFrom) {
            $("#from_date_jalali").pDatepicker("setDate", new persianDate(new Date(initialFrom)));
        }

        const initialTo = $('#to_date_gregorian').val();
        if (initialTo) {
            $("#to_date_jalali").pDatepicker("setDate", new persianDate(new Date(initialTo)));
        }

        toggleDateInputs($('select[name="range"]').val());

        @if(!empty($chartData['labels']) && !empty($chartData['data']))
        new Chart(document.getElementById('leadChart'), {
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
                            font: { family: 'Vazirmatn' }
                        }
                    },
                    tooltip: {
                        rtl: true,
                        bodyFont: { family: 'Vazirmatn' },
                        titleFont: { family: 'Vazirmatn' }
                    }
                },
                scales: {
                    x: {
                        ticks: { font: { family: 'Vazirmatn' } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { font: { family: 'Vazirmatn' } }
                    }
                }
            }
        });
        @endif
    });
</script>
@endsection
