<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Vazirmatn', sans-serif; direction: rtl; }
</style>

<div class="container mt-4">
    <h3 class="mb-3">لیست مشتریان احتمالی</h3>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('leads.create') }}" class="btn btn-success mb-3">+ افزودن مشتری احتمالی</a>

    <form action="{{ route('leads.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-md-2">
            <input type="text" name="search" class="form-control" placeholder="نام یا تلفن" value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="company" class="form-control" placeholder="شرکت" value="{{ request('company') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="source" class="form-control" placeholder="منبع" value="{{ request('source') }}">
        </div>
        <div class="col-md-2">
            <select name="interest_level" class="form-select">
                <option value="">سطح علاقه</option>
                <option value="کم" {{ request('interest_level') == 'کم' ? 'selected' : '' }}>کم</option>
                <option value="متوسط" {{ request('interest_level') == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                <option value="زیاد" {{ request('interest_level') == 'زیاد' ? 'selected' : '' }}>زیاد</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">وضعیت</option>
                <option value="در انتظار تماس" {{ request('status') == 'در انتظار تماس' ? 'selected' : '' }}>در انتظار تماس</option>
                <option value="تماس گرفته شد" {{ request('status') == 'تماس گرفته شد' ? 'selected' : '' }}>تماس گرفته شد</option>
                <option value="تبدیل به مشتری شد" {{ request('status') == 'تبدیل به مشتری شد' ? 'selected' : '' }}>تبدیل به مشتری شد</option>
            </select>
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-outline-primary">جستجو</button>
        </div>
    </form>

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
                <th>عملیات</th>
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
                    <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-secondary mb-1">مشاهده تماس‌ها</a>
                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-warning mb-1">ویرایش</a>
                    <form action="{{ route('leads.convert', $lead->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success mb-1">تبدیل به مشتری</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $leads->links() }}
    </div>
</div>

