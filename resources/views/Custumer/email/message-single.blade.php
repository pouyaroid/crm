<form method="POST" action="{{ route('customers.message.send') }}">
    @csrf
    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
    <textarea name="message" class="form-control" rows="5" placeholder="متن پیام را وارد کنید"></textarea>
    <button type="submit" class="btn btn-primary mt-2">ارسال</button>
</form>
