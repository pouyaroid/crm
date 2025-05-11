{{-- استایل‌ها --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Vazirmatn', sans-serif; direction: rtl; background-color: #f8f9fa; }
    .custom-date-inputs { display: flex; gap: 1rem; }
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
            <label class="form-label">از تاریخ تا تاریخ</label>
            <div class="custom-date-inputs">
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
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

{{-- اسکریپت نمودار --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleDateInputs(value) {
        const customDates = document.getElementById('custom-dates-wrapper');
        customDates.style.display = (value === 'custom') ? 'flex' : 'none';
    }

    const ctx = document.getElementById('leadChart')?.getContext('2d');
    @if(!empty($chartData['labels']))
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
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    @endif
</script>
