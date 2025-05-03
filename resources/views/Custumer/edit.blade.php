<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش مشتری</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            background: #f1f1f1;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .form-control, .btn {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container bg-white shadow p-5 rounded">

    <h3 class="mb-4 text-center text-primary">ویرایش اطلاعات مشتری</h3>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">نام شخص</label>
            <input type="text" name="personal_name" class="form-control" value="{{ $customer->personal_name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">نام شرکت</label>
            <input type="text" name="company_name" class="form-control" value="{{ $customer->company_name }}">
        </div>

        <div class="mb-3">
            <label class="form-label">نوع شرکت</label>
            <input type="text" name="company_type" class="form-control" value="{{ $customer->company_type }}">
        </div>

        <div class="mb-3">
            <label class="form-label">ایمیل</label>
            <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
        </div>

        <div class="mb-3">
            <label class="form-label">آدرس</label>
            <textarea name="address" class="form-control" rows="2">{{ $customer->address }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">مدیرعامل</label>
            <input type="text" name="ceo" class="form-control" value="{{ $customer->ceo }}">
        </div>

        <div class="mb-3">
            <label class="form-label">بانک</label>
            <input type="text" name="bank" class="form-control" value="{{ $customer->bank }}">
        </div>

        <div class="mb-3">
            <label class="form-label">شماره حساب</label>
            <input type="text" name="account_number" class="form-control" value="{{ $customer->account_number }}">
        </div>

        <div class="mb-3">
            <label class="form-label">شماره شرکت</label>
            <input type="text" name="company_phone" class="form-control" value="{{ $customer->company_phone }}">
        </div>

        <div class="mb-3">
            <label class="form-label">شماره موبایل</label>
            <input type="text" name="mobile_phone" class="form-control" value="{{ $customer->mobile_phone }}">
        </div>

        <div class="mb-3">
            <label class="form-label">کد ملی</label>
            <input type="text" name="id_meli" class="form-control" value="{{ $customer->id_meli }}">
        </div>

        <div class="mb-3">
            <label class="form-label">کد پستی</label>
            <input type="text" name="postal_code" class="form-control" value="{{ $customer->postal_code }}">
        </div>

        <div class="mb-3">
            <label class="form-label">کد اقتصادی</label>
            <input type="text" name="code_eghtesadi" class="form-control" value="{{ $customer->code_eghtesadi }}">
        </div>

        <div class="mb-3">
            <label class="form-label">توضیحات</label>
            <textarea name="note" class="form-control" rows="2">{{ $customer->note }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">بازگشت</a>
            <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
        </div>
    </form>

</div>

</body>
</html>
