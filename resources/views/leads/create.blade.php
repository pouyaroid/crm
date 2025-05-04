<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
<style> body { font-family: 'Vazirmatn', sans-serif; direction: rtl; } </style>
<div class="container mt-4">
    <h3 class="mb-4">ثبت مشتری احتمالی جدید</h3>
    <form action="{{ route('leads.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">نام</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">تلفن</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="company" class="form-label">شرکت</label>
            <input type="text" name="company" class="form-control">
        </div>
        <div class="mb-3">
            <label for="source" class="form-label">منبع آشنایی</label>
            <input type="text" name="source" class="form-control">
        </div>
        <div class="mb-3">
            <label for="interest_level" class="form-label">سطح علاقه‌مندی</label>
            <select name="interest_level" class="form-select">
                <option value="کم">کم</option>
                <option value="متوسط" selected>متوسط</option>
                <option value="زیاد">زیاد</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="در انتظار تماس">در انتظار تماس</option>
                <option value="تماس گرفته شد">تماس گرفته شد</option>
                <option value="تبدیل به مشتری شد">تبدیل به مشتری شد</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">یادداشت</label>
            <textarea name="note" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">ذخیره</button>
    </form>
</div>