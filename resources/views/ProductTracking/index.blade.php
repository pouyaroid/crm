<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رهگیری محصولات</title>

    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- فونت فارسی -->
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background: #f0f2f5;
        }

        .container {
            margin-top: 40px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #343a40;
            font-weight: 700;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .badge-status {
            font-size: 0.9rem;
            padding: 0.4em 0.8em;
            border-radius: 50px;
        }

        .status-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .status-shipped {
            background-color: #17a2b8;
        }

        .status-delivered {
            background-color: #28a745;
        }

        .status-cancelled {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>رهگیری محصولات</h1>
    <form action="{{ route('tracking.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="جستجو بر اساس کد رهگیری، یادداشت یا وضعیت">
            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> جستجو</button>
        </div>
    </form>

    <div class="row">
        @forelse($traking as $item)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-box-seam"></i> یادداشت: {{ $item->note ?? 'نامشخص' }}</h5>
                        <p class="card-text"><strong>کد رهگیری:</strong> {{ $item->product_code }}</p>
                        <p class="card-text"><strong>تاریخ ثبت:</strong> {{ jdate($item->created_at)->format('Y/m/d') }}</p>
                        <a href="{{ route('tracking.edit', $item->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil"></i> ویرایش
                        </a>
                        <p class="card-text">
                            <strong>وضعیت:</strong>
                            <span class="badge badge-status 
                                @switch($item->status)
                                    @case('در انتظار') status-pending @break
                                    @case('ارسال شده') status-shipped @break
                                    @case('تحویل داده شده') status-delivered @break
                                    @case('لغو شده') status-cancelled @break
                                    @default status-pending
                                @endswitch">
                                {{ $item->status }}
                            </span>
                        </p>
                        @if($item->description)
                            <p class="card-text text-muted">{{ $item->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    هیچ اطلاعاتی برای رهگیری ثبت نشده است.
                </div>
            </div>
        @endforelse
        <div class="d-flex justify-content-center">
            {{ $traking->withQueryString()->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
