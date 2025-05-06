<form method="POST" action="{{ route('customers.message.send') }}">
    @csrf

    <h4>لیست مشتریان:</h4>
    @foreach($customers as $customer)
        <div>
            <label>
                <input type="checkbox" name="selected_customers[]" value="{{ $customer->id }}">
                {{ $customer->name }} ({{ $customer->email }})
            </label>
        </div>
    @endforeach

    <div class="mt-3">
        <label for="message">متن پیام:</label>
        <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-success mt-3">ارسال ایمیل گروهی</button>
</form>