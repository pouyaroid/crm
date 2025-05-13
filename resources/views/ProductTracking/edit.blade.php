@section('content')

<div class="container mt-5">
    <h2 class="mb-4">ویرایش وضعیت مرسوله</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tracking.update', $productTracking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_code" class="form-label">کد محصول</label>
            <input type="text" class="form-control" id="product_code" name="product_code"
                   value="{{ old('product_code', $productTracking->product_code) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">وضعیت</label>
            <select name="status" id="status" class="form-select" required>
                @php
                    $statuses = ['انبار', 'درحال ارسال', 'ارسال شد', 'درحال تولید', 'آماده سازی'];
                @endphp
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ $productTracking->status === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">یادداشت (اختیاری)</label>
            <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $productTracking->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
        <a href="{{ route('tracking.index') }}" class="btn btn-secondary">بازگشت</a>
    </form>
</div>