@extends('layouts.app')

@section('title', 'مشاهده پرونده')

@section('content')
<div class="container mt-4">
    <h2>جزئیات پرونده</h2>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">{{ $case->case_title }}</h5>
            <p class="card-text">شناسه مشتری: {{ $case->customer_id }}</p>
            <p class="card-text">توضیحات: {{ $case->description }}</p>
        </div>
    </div>

    <h4 class="mt-4">مدارک آپلود شده</h4>
    @if ($case->documents->count())
        <ul class="list-group mt-2">
            @foreach ($case->documents as $doc)
                <li class="list-group-item">
                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ basename($doc->file_path) }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted mt-2">هیچ مدرکی آپلود نشده است.</p>
    @endif
</div>
@endsection
