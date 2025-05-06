<form method="POST" action="{{ route('customers.message.bulk.send') }}">
    @csrf

    <div>
        <label>مخاطبین:</label><br>
        @foreach($customers as $customer)
            <input type="checkbox" name="selected_customers[]" value="{{ $customer->id }}" checked>
            {{ $customer->name }} ({{ $customer->email }}) <br>
        @endforeach
    </div>

    <div>
        <label>متن پیام:</label><br>
        <textarea name="message" rows="5" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-success">ارسال ایمیل گروهی</button>
</form>