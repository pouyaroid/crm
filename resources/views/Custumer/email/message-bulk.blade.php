<form method="POST" action="{{ route('customers.message.bulk.send') }}">
    @csrf
    @foreach($customers as $customer)
        <input type="hidden" name="customer_ids[]" value="{{ $customer->id }}">
        <p>{{ $customer->personal_name }} - {{ $customer->mobile_phone }}</p>
    @endforeach

    <textarea name="message" class="form-control" rows="5" placeholder="متن پیام برای همه مشتریان"></textarea>
    <button type="submit" class="btn btn-success mt-2">ارسال پیام گروهی</button>
</form>
