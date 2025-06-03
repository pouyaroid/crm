@extends('layouts.app')

@section('title', 'رهگیری محصولات')

@section('content')
{{-- Custom Styles for this specific page ONLY --}}
<style>
    /* Page-specific background and overall container styling */
    .page-wrapper-tracking {
        background: linear-gradient(135deg, #f0f8ff 0%, #e6f7ff 100%); /* Lighter, more vibrant background for this page */
        min-height: calc(100vh - 60px); /* Adjust based on your header/footer height */
        padding: 30px; /* Generous padding around the content */
        border-radius: 15px; /* Subtle rounded corners for the content area */
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08); /* Soft shadow for the content area */
        margin-top: 20px; /* Space from top (e.g., header/navbar) */
        margin-bottom: 20px; /* Space from bottom (e.g., footer) */
        direction: rtl; /* Ensure RTL for this specific content block */
        text-align: right; /* Ensure text alignment for RTL */
    }

    /* Page Title Styling */
    .page-title-tracking {
        font-size: 2.5rem; /* Larger, more prominent title */
        font-weight: 800; /* Extra bold */
        color: #0056b3; /* Darker blue */
        text-align: center;
        margin-bottom: 40px; /* More space below title */
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        position: relative;
        padding-bottom: 15px;
    }
    .page-title-tracking::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px; /* Short underline */
        height: 4px;
        background: linear-gradient(to right, #007bff, #17a2b8); /* Gradient underline */
        border-radius: 2px;
    }
    .page-title-tracking i {
        font-size: 2.8rem; /* Larger icon */
        color: #007bff;
        text-shadow: 1px 1px 3px rgba(0, 123, 255, 0.2);
    }

    /* Search Form Styling */
    .search-form-tracking .input-group {
        max-width: 600px; /* Limit width of search bar */
        margin: 0 auto 40px auto; /* Center and add bottom margin */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Shadow for search bar */
        border-radius: 12px; /* Rounded corners for the whole group */
        overflow: hidden; /* Ensure inner elements respect border-radius */
    }
    .search-form-tracking .form-control {
        border-radius: 0 !important; /* Reset default Bootstrap border-radius */
        border: none !important; /* Remove individual borders */
        padding: 15px 20px; /* More padding */
        font-size: 1.05rem;
        background-color: #ffffff;
    }
    .search-form-tracking .form-control:focus {
        box-shadow: none !important; /* Remove default focus shadow */
    }
    .search-form-tracking .btn-primary {
        border-radius: 0 !important; /* Reset default Bootstrap border-radius */
        background: linear-gradient(135deg, #007bff, #0056b3); /* Primary blue gradient */
        border: none;
        padding: 15px 25px;
        font-size: 1.05rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .search-form-tracking .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3, #007bff);
        transform: none; /* Remove lift on hover */
        box-shadow: none; /* Remove shadow on hover */
    }
    .search-form-tracking .btn-primary i {
        margin-left: 8px;
    }

    /* Product Card Styling */
    .product-card {
        border-radius: 18px; /* More rounded corners */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Soft, deep shadow */
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Smooth transition for hover effects */
        border: none; /* Remove default border */
        background: linear-gradient(160deg, #ffffff 95%, #f8fcff 100%); /* Subtle gradient background */
        overflow: hidden;
        position: relative;
        min-height: 220px; /* Ensure consistent height for cards */
    }
    .product-card:hover {
        transform: translateY(-8px) scale(1.02); /* More prominent lift and scale */
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.18); /* Enhanced shadow on hover */
        border-right: 5px solid #007bff; /* Highlight on hover */
    }
    .product-card .card-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Distribute content vertically */
        height: 100%;
    }
    .product-card .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0056b3;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .product-card .card-title i {
        font-size: 1.6rem;
        color: #007bff;
    }
    .product-card .card-text {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 10px;
    }
    .product-card .card-text strong {
        color: #333;
    }
    .product-card .text-muted {
        font-size: 0.85rem;
        color: #777 !important;
        line-height: 1.5;
    }
    .product-card .btn-outline-primary {
        border-radius: 20px;
        padding: 8px 18px;
        font-size: 0.9rem;
        font-weight: 600;
        border-width: 2px;
        transition: all 0.3s ease;
        color: #007bff;
        border-color: #007bff;
    }
    .product-card .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
        transform: translateY(-2px);
    }
    .product-card .btn-outline-primary i {
        margin-left: 8px;
    }

    /* Status Badges */
    .badge-status {
        font-size: 0.9rem;
        padding: 0.5em 1em;
        border-radius: 50px;
        font-weight: 600;
        color: white; /* Default white text for badges */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .status-pending { background-color: #ffc107; color: #212529; } /* Yellow, dark text */
    .status-shipped { background-color: #17a2b8; } /* Teal */
    .status-delivered { background-color: #28a745; } /* Green */
    .status-cancelled { background-color: #dc3545; } /* Red */
    .status-unknown { background-color: #6c757d; } /* Grey for default/unknown */

    /* No tracking info alert */
    .alert-info-tracking {
        background-color: #e0f7fa; /* Light blue */
        color: #007bff;
        border-color: #b3e5fc;
        border-radius: 15px;
        padding: 25px;
        font-size: 1.1rem;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    /* Pagination Styling (consistent with previous views) */
    .pagination .page-link {
        border-radius: 50% !important;
        margin: 0 4px;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        border: 1px solid #dee2e6;
        color: #007bff;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .pagination .page-link:hover {
        background-color: #007bff;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        transform: scale(1.08);
    }
    .pagination .page-item.disabled .page-link {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Animations */
    .animate-card {
        animation: fadeInUp 0.7s ease-out forwards;
        opacity: 0; /* Start hidden */
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    /* Apply animation delay to stagger cards */
    @for ($i = 0; $i < 20; $i++) /* Adjust max number based on your pagination limit */
        .product-card-{{ $i }} { animation-delay: {{ $i * 0.1 }}s; }
    @endfor


    /* Responsive Adjustments */
    @media (max-width: 1200px) { /* Large desktops / tablets */
        .page-wrapper-tracking { padding: 25px; }
        .page-title-tracking { font-size: 2.2rem; margin-bottom: 30px; }
        .page-title-tracking i { font-size: 2.5rem; }
        .search-form-tracking .input-group { max-width: 500px; margin-bottom: 30px; }
        .product-card { min-height: 200px; }
        .product-card .card-title { font-size: 1.2rem; }
        .product-card .card-title i { font-size: 1.5rem; }
    }

    @media (max-width: 992px) { /* Medium desktops / tablets */
        .page-wrapper-tracking { padding: 20px; }
        .page-title-tracking { font-size: 2rem; margin-bottom: 25px; }
        .page-title-tracking i { font-size: 2.2rem; }
        .search-form-tracking .input-group { max-width: 100%; margin-bottom: 25px; }
        .product-card { min-height: 180px; }
        .product-card .card-title { font-size: 1.1rem; }
        .product-card .card-title i { font-size: 1.4rem; }
        .product-card .card-text { font-size: 0.9rem; }
        .product-card .btn-outline-primary { padding: 6px 15px; font-size: 0.85rem; }
        .badge-status { font-size: 0.8rem; padding: 0.4em 0.7em; }
    }

    @media (max-width: 767px) { /* Small tablets / mobile */
        .page-wrapper-tracking { padding: 15px; margin-top: 10px; margin-bottom: 10px; border-radius: 10px; }
        .page-title-tracking { font-size: 1.8rem; margin-bottom: 20px; }
        .page-title-tracking i { font-size: 2rem; }
        .search-form-tracking .form-control, .search-form-tracking .btn-primary {
            padding: 12px 15px;
            font-size: 0.95rem;
        }
        .product-card { min-height: auto; padding-bottom: 15px; } /* Allow height to adjust */
        .product-card .card-body { padding: 20px; }
        .product-card .card-title { font-size: 1.05rem; }
        .product-card .card-title i { font-size: 1.3rem; }
        .product-card .card-text { font-size: 0.85rem; margin-bottom: 8px; }
        .product-card .text-muted { font-size: 0.75rem; }
        .product-card .btn-outline-primary { padding: 5px 12px; font-size: 0.8rem; }
        .badge-status { font-size: 0.75rem; padding: 0.3em 0.6em; }
        .alert-info-tracking { padding: 15px; font-size: 1rem; }
        .pagination .page-link { width: 40px; height: 40px; font-size: 0.9rem; }
    }

    @media (max-width: 576px) { /* Very small screens / mobile */
        .page-wrapper-tracking { padding: 10px; }
        .page-title-tracking { font-size: 1.5rem; margin-bottom: 15px; }
        .page-title-tracking i { font-size: 1.7rem; }
        .search-form-tracking .input-group { border-radius: 8px; }
        .search-form-tracking .form-control, .search-form-tracking .btn-primary {
            padding: 10px 12px;
            font-size: 0.9rem;
        }
        .product-card { border-radius: 12px; }
        .product-card .card-body { padding: 15px; }
        .product-card .card-title { font-size: 1rem; }
        .product-card .card-title i { font-size: 1.2rem; }
        .product-card .card-text { font-size: 0.8rem; }
        .product-card .btn-outline-primary { padding: 4px 10px; font-size: 0.75rem; }
        .badge-status { font-size: 0.7rem; padding: 0.25em 0.5em; }
        .pagination .page-link { width: 35px; height: 35px; font-size: 0.85rem; }
    }
</style>

<div class="page-wrapper-tracking">
    <div class="container">
        <h1 class="page-title-tracking">
            <i class="bi bi-truck"></i>رهگیری محصولات
        </h1>

        <form action="{{ route('tracking.index') }}" method="GET" class="search-form-tracking mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="جستجو بر اساس کد رهگیری، یادداشت یا وضعیت">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> جستجو</button>
            </div>
        </form>

        <div class="row">
            @forelse($traking as $index => $item)
                {{-- Added product-card-{{ $index }} for staggered animation --}}
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 animate-card product-card-{{ $index }}">
                    <div class="card product-card h-100"> {{-- h-100 to make cards in a row equal height --}}
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">
                                    <i class="bi bi-box-seam"></i>یادداشت: {{ $item->note ?? 'نامشخص' }}
                                </h5>
                                <p class="card-text"><strong>کد رهگیری:</strong> {{ $item->product_code }}</p>
                                <p class="card-text"><strong>تاریخ ثبت:</strong> {{ jdate($item->created_at)->format('Y/m/d') }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('tracking.edit', $item->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i> ویرایش
                                </a>
                                <span class="badge badge-status 
                                    @switch($item->status)
                                        @case('در انتظار') status-pending @break
                                        @case('ارسال شده') status-shipped @break
                                        @case('تحویل داده شده') status-delivered @break
                                        @case('لغو شده') status-cancelled @break
                                        @default status-unknown
                                    @endswitch">
                                    {{ $item->status }}
                                </span>
                            </div>
                            @if($item->description)
                                <p class="card-text text-muted mt-2">{{ $item->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info alert-info-tracking text-center">
                        هیچ اطلاعاتی برای رهگیری ثبت نشده است.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $traking->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

{{-- No @section('scripts') needed unless there's page-specific JS --}}
