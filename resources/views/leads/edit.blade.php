<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
<style> body { font-family: 'Vazirmatn', sans-serif; direction: rtl; } </style>

<div class="container mt-4">
    <h3 class="mb-4">ویرایش مشتری احتمالی</h3>

    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">نام</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $lead->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">تلفن</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $lead->phone) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">شرکت</label>
            <input type="text" name="company" class="form-control" value="{{ old('company', $lead->company) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">منبع آشنایی</label>
            <input type="text" name="source" class="form-control" value="{{ old('source', $lead->source) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">سطح علاقه‌مندی</label>
            <select name="interest_level" class="form-select">
                <option value="کم" {{ $lead->interest_level == 'کم' ? 'selected' : '' }}>کم</option>
                <option value="متوسط" {{ $lead->interest_level == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                <option value="زیاد" {{ $lead->interest_level == 'زیاد' ? 'selected' : '' }}>زیاد</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="در انتظار تماس" {{ $lead->status == 'در انتظار تماس' ? 'selected' : '' }}>در انتظار تماس</option>
                <option value="تماس گرفته شد" {{ $lead->status == 'تماس گرفته شد' ? 'selected' : '' }}>تماس گرفته شد</option>
                <option value="تبدیل به مشتری شد" {{ $lead->status == 'تبدیل به مشتری شد' ? 'selected' : '' }}>تبدیل به مشتری شد</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">یادداشت</label>
            <textarea name="note" class="form-control" rows="3">{{ old('note', $lead->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
        <a href="{{ route('leads.index') }}" class="btn btn-secondary">بازگشت</a>
    </form>
</div>

