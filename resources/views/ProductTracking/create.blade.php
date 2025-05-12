<div class="container">
    <h2>ثبت وضعیت جدید برای محصول</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tracking.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="product_code">کد محصول</label>
            <input type="text" name="product_code" id="product_code" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="status">وضعیت</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">-- انتخاب وضعیت --</option>
                <option value="انبار">انبار</option>
                <option value="درحال ارسال">درحال ارسال</option>
                <option value="ارسال شد">ارسال شد</option>
                <option value="درحال تولید">درحال تولید</option>
                <option value="آماده سازی">آماده سازی</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="note">توضیحات</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-4">ثبت وضعیت</button>
    </form>
</div>