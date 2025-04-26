<h3>گزارش یک سال اخیر</h3>
@foreach($lastYearCounts as $status => $count)
    <p>{{ $status }}: {{ $count }} مورد</p>
@endforeach