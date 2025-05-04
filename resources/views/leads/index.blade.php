<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Vazirmatn', sans-serif; direction: rtl; }
</style>

<div class="container mt-4">
    <h3 class="mb-3">لیست مشتریان احتمالی</h3>
    <a href="{{ route('leads.create') }}" class="btn btn-success mb-3">+ افزودن مشتری احتمالی</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>نام</th>
                <th>تلفن</th>
                <th>شرکت</th>
                <th>منبع</th>
                <th>سطح علاقه</th>
                <th>وضعیت</th>
                <th>یادداشت</th>
                <th>عملیات</th> {{-- ستون جدید برای دکمه‌ها --}}
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
                <td>{{ $lead->note }}</td>
                <td>
                    <a href="{{ route('leads.calls.create', $lead->id) }}" class="btn btn-sm btn-primary mb-1">افزودن تماس</a>
                    <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-secondary">مشاهده تماس‌ها</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $leads->links() }}
    </div>
</div>
