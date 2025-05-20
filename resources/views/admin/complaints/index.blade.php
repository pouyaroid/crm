@extends('layouts.app')
@section('title','مشاهده شکایات')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font/dist/font-face.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background-color: #f3f6f9;
            color: #333;
        }
        .container {
            max-width: 1000px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }
        .image-gallery img {
            max-width: 150px;
            border-radius: 8px;
            cursor: pointer;
        }
        .video-container {
            margin-top: 15px;
        }
        .divider {
            border-top: 1px solid #e0e0e0;
            margin: 30px 0;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">پنل مدیریت شکایت‌ها</h2>

    {{-- فرم جستجو --}}
    <form method="GET" action="{{ route('complaints.index') }}" class="mb-5">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <input type="text" name="title" class="form-control" placeholder="عنوان شکایت" value="{{ request('title') }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="ordernumber" class="form-control" placeholder="شماره سفارش" value="{{ request('ordernumber') }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="user" class="form-control" placeholder="نام کاربر" value="{{ request('user') }}">
            </div>
            <div class="col-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">جستجو</button>
                <a href="{{ route('complaints.index') }}" class="btn btn-secondary">ریست</a>
            </div>
        </div>
    </form>

    {{-- لیست شکایت‌ها --}}
    @forelse($complaints as $complaint)
        <div class="card mb-4">
            <h5 class="card-title text-primary">{{ $complaint->title }}</h5>
            <p><strong>نام کاربر:</strong> {{ $complaint->user->name ?? 'نامشخص' }}</p>
            <p><strong>شماره سفارش:</strong> {{ $complaint->ordernumber ?? '-' }}</p>
            <p><strong>توضیحات:</strong> {{ $complaint->description }}</p>

            @if($complaint->images->count())
                <div><strong>تصاویر:</strong></div>
                <div class="d-flex flex-wrap gap-2 image-gallery mt-2">
                    @foreach($complaint->images as $image)
                        <a href="{{ asset('storage/' . $image->path) }}" data-lightbox="gallery-{{ $complaint->id }}">
                            <img src="{{ asset('storage/' . $image->path) }}" class="img-thumbnail">
                        </a>
                    @endforeach
                </div>
            @endif

            @if($complaint->video_path)
                <div class="video-container">
                    <strong>ویدیو:</strong><br>
                    <video controls style="max-width: 100%;">
                        <source src="{{ asset('storage/' . $complaint->video_path) }}" type="video/mp4">
                        مرورگر شما از پخش این ویدیو پشتیبانی نمی‌کند.
                    </video>
                </div>
            @endif
        </div>
        <div class="divider"></div>
    @empty
        <div class="alert alert-info text-center">هیچ شکایتی پیدا نشد.</div>
    @endforelse
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

</body>
</html>
@endsection
