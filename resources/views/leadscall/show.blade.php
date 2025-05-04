@if($lead->calls->count())
    <div class="mt-4">
        <h5 class="mb-3">تماس‌های خروجی:</h5>
        <ul class="list-group">
            @foreach($lead->calls as $call)
                <li class="list-group-item">
                    <strong>{{ $call->call_summary }}</strong><br>
                    <small class="text-muted">{{ jdate($call->call_time)->format('Y/m/d H:i') }}</small><br>
                    <div>{{ $call->notes }}</div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
