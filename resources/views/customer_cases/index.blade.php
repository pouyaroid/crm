@extends('layouts.app')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-folder2-open fs-2 ms-2 text-primary"></i>
                <h2 class="fw-bold">پرونده‌های {{ $customer->personal_name ?? $customer->name }}</h2>
            </div>
            @forelse($cases as $case)
                <div class="card mb-4 shadow-sm" style="background-color: #fcfcfc;">
                    <div class="card-body">
                        <div class="mb-3">
                            <h5 class="card-title text-primary fw-bold mb-1"><i class="bi bi-briefcase ms-2"></i>{{ $case->title }}</h5>
                            <p class="card-text mb-2">{{ $case->description }}</p>
                            <span class="badge bg-secondary mb-2">
                                <i class="bi bi-calendar-event ms-1"></i>
                                تاریخ ثبت: {{ $case->created_at->format('Y-m-d') }}
                            </span>
                        </div>
                        @if($case->documents && $case->documents->count() > 0)
                            <div class="mt-3">
                                <h6 class="fw-bold"><i class="bi bi-paperclip ms-1"></i>مدارک:</h6>
                                <div class="row g-2">
                                    @foreach($case->documents as $document)
                                        @php
                                            $ext = pathinfo($document->file_path, PATHINFO_EXTENSION);
                                        @endphp
                                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/' . $document->file_path) }}" alt="مدرک"
                                                    class="img-thumbnail"
                                                    style="max-width:120px; max-height:120px;">
                                            </div>
                                        @else
                                            <div class="col-12">
                                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm my-1">
                                                    <i class="bi bi-file-earmark-arrow-down ms-1"></i>
                                                    مشاهده فایل{{ $document->file_type ? ' ('.$document->file_type.')' : '' }}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info mt-4">
                    هیچ پرونده‌ای برای این کاربر ثبت نشده است.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection