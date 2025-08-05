@extends('layouts.app')

@section('content')
<div class="container">
    <h4>ثبت تماس برای {{ $customer->company_name }}</h4>

    <form action="{{ route('customer.calls.store', $customer->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>عنوان تماس</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>توضیحات</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button class="btn btn-success">ثبت</button>
    </form>
</div>
@endsection
