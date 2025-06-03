@extends('layouts.app')

@section('title', 'جزئیات تماس‌های لید')

@section('content')
{{-- Custom Styles for this specific page ONLY --}}
<style>
    /* Ensure Vazirmatn font is used and RTL direction for this specific content block */
    .page-wrapper-calls {
        font-family: 'Vazirmatn', sans-serif !important; /* Override if needed */
        direction: rtl !important;
        text-align: right !important;
        background: linear-gradient(135deg, #f0f8ff 0%, #e6f7ff 100%); /* Light blue gradient background for the content area */
        min-height: calc(100vh - 60px); /* Adjust based on your header/footer height */
        padding: 30px; /* Generous padding around the content */
        border-radius: 15px; /* Subtle rounded corners for the content area */
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08); /* Soft shadow for the content area */
        margin-top: 20px; /* Space from top (e.g., header/navbar) */
        margin-bottom: 20px; /* Space from bottom (e.g., footer) */
    }

    /* Styles for the main calls container card */
    .calls-card {
        background: linear-gradient(135deg, #f3f8fe 90%, #e6f2ff 100%);
        border-radius: 26px;
        box-shadow: 0 2px 44px rgba(186, 216, 255, 0.27), 0 1.5px 10px rgba(212, 232, 253, 0.4); /* Adjusted shadow opacity */
        border: none;
        padding: 48px 36px 32px 36px;
        margin-bottom: 36px;
        transition: all 0.4s ease; /* Smooth transition for general card */
    }
    .calls-card:hover {
        box-shadow: 0 4px 60px rgba(186, 216, 255, 0.35), 0 3px 15px rgba(212, 232, 253, 0.5); /* Enhanced shadow on hover */
    }

    /* Styles for the section title (e.g., "تماس‌های خروجی") */
    .calls-title {
        color: #2475f2;
        font-weight: 900;
        font-size: 1.8rem; /* Slightly larger for better readability */
        letter-spacing: -0.5px;
        margin-bottom: 28px; /* More space below title */
        display: flex;
        align-items: center;
        gap: 12px;
        user-select: none;
        border-bottom: 2px solid #e0f2ff; /* Subtle underline */
        padding-bottom: 15px;
    }
    .calls-title i {
        background: linear-gradient(120deg,#e5eeff,#dbe9fe 56%,#97cafd 84%);
        color: #1875f0;
        border-radius: 12px;
        font-size: 2.2rem; /* Larger icon */
        padding: 8px 13px 8px 8px; /* Adjusted padding */
        box-shadow: 0 2px 12px rgba(195, 229, 255, 0.2);
        transition: background 0.25s;
    }

    /* Styles for individual call cards */
    .call-card {
        background: linear-gradient(110deg, #ffffff 96%, #f0f7ff 100%);
        border-radius: 20px;
        box-shadow: 0 3px 20px rgba(211, 231, 250, 0.33), 0 1.5px 8px rgba(220, 237, 254, 0.37); /* Adjusted shadow opacity */
        transition: all 0.35s cubic-bezier(.22,.68,.51,1.26); /* Smoother bounce effect */
        min-height: 140px; /* Slightly increased min-height */
        position: relative;
        overflow: hidden;
        border: none;
        border-right: 5px solid transparent; /* Wider right border for status */
        outline: 0;
        display: flex; /* Use flexbox to make content fill height */
        flex-direction: column;
    }
    .call-card:hover {
        box-shadow: 0 7px 28px rgba(166, 209, 252, 0.4), 0 1.5px 12px rgba(153, 201, 250, 0.47); /* Enhanced hover shadow */
        transform: translateY(-8px) scale(1.035); /* More prominent lift and scale */
        background: linear-gradient(107deg, #fafdff 89%, #e4f2ff 100%);
        border-right: 5px solid #217ad9; /* Highlight on hover */
    }
    .call-card .card-body {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-grow: 1; /* Allow content to grow and fill available space */
    }

    /* Styles for call summary text */
    .call-summary {
        font-size: 1.15rem; /* Slightly larger font */
        color: #2576dd;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px; /* Space below summary */
        flex-wrap: wrap; /* Allow wrapping on small screens */
    }
    .call-summary i {
        font-size: 1.35rem; /* Larger icon */
        background: #e7f4ff;
        color: #49b0ff;
        border-radius: 8px;
        padding: 4px 6px 4px 3px; /* Adjusted padding */
        margin-left: 5px; /* More space for icon */
    }

    /* Styles for call date text */
    .call-date {
        font-size: 1.05rem; /* Slightly larger font */
        color: #929eb7;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 400;
        white-space: nowrap; /* Prevent date from wrapping */
    }
    .call-date i {
        font-size: 1.18rem; /* Larger icon */
        color: #a7b7d0; /* Muted color for date icon */
    }

    /* Styles for call notes text */
    .call-note {
        font-size: 1.02rem; /* Slightly larger font */
        color: #527097;
        margin-top: 15px; /* More space above notes */
        display: flex;
        align-items: flex-start;
        gap: 7px;
        border-right: 3px solid #dfedfe; /* Thicker border */
        padding-right: 10px; /* More padding */
        background: #f7fbff;
        border-radius: 7px;
        padding-top: 8px;
        padding-bottom: 8px;
        line-height: 1.6; /* Better line spacing */
    }
    .call-note i {
        color: #64bdee;
        background: #e1f2fe;
        border-radius: 8px;
        font-size: 1.15rem; /* Larger icon */
        padding: 3px 7px 3px 3px; /* Adjusted padding */
        margin-left: 5px; /* More space for icon */
    }

    /* Corner background element within call cards */
    .call-card .corner-bg {
        position: absolute;
        left: -45px;
        bottom: -40px;
        width: 150px;
        height: 90px;
        background: linear-gradient(-45deg, #e7f0ff 0%, #61b4fd 100%);
        opacity: 0.11;
        transform: rotate(-12deg);
        pointer-events: none;
        z-index: 0;
        border-radius: 90px 99px 32px 14px;
    }

    /* Spacing between call cards */
    .calls-card .call-card:not(:last-child) {
        margin-bottom: 20px; /* More consistent spacing */
    }

    /* Responsive Styles */
    @media (max-width: 1200px) { /* Large desktops / tablets */
        .calls-card { padding: 40px 30px 28px 30px; }
        .calls-title { font-size: 1.6rem; margin-bottom: 25px; }
        .calls-title i { font-size: 2rem; padding: 7px 12px 7px 7px; }
        .call-card { min-height: 130px; }
        .call-summary { font-size: 1.1rem; }
        .call-date { font-size: 0.98rem; }
        .call-note { font-size: 0.98rem; }
    }

    @media (max-width: 991px) { /* Medium desktops / tablets */
        .calls-card { padding: 30px 25px 20px 25px; }
        .calls-title { font-size: 1.4rem; margin-bottom: 20px; }
        .calls-title i { font-size: 1.8rem; padding: 6px 10px 6px 6px; }
        .call-card { min-height: 120px; }
        .call-summary { font-size: 1.05rem; }
        .call-date { font-size: 0.95rem; }
        .call-note { font-size: 0.95rem; }
        /* Flex wrap for summary and date on smaller screens */
        .call-card .d-flex.align-items-center.justify-content-between {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }

    @media (max-width: 767px) { /* Small tablets / mobile */
        .page-wrapper-calls {
            padding: 15px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .calls-card { padding: 20px 15px 15px 15px; border-radius: 20px; }
        .calls-title { font-size: 1.2rem; margin-bottom: 15px; }
        .calls-title i { font-size: 1.6rem; padding: 5px 8px 5px 5px; }
        .call-card { min-height: 105px; border-right: 3px solid transparent; }
        .call-card:hover { border-right: 3px solid #217ad9; }
        .call-summary { font-size: 0.95rem; }
        .call-summary i { font-size: 1.15rem; padding: 3px 5px 3px 2px; }
        .call-date { font-size: 0.85rem; }
        .call-note { font-size: 0.88rem; padding-right: 8px; border-right: 2px solid #dfedfe; }
        .call-note i { font-size: 1rem; padding: 2px 5px 2px 2px; }
    }

    @media (max-width: 576px) { /* Very small screens / mobile */
        .calls-card { padding: 15px 10px 10px 10px; border-radius: 15px; }
        .calls-title { font-size: 1.1rem; gap: 8px; margin-bottom: 10px; }
        .calls-title i { font-size: 1.4rem; padding: 4px 7px 4px 4px; }
        .call-card { min-height: 90px; }
        .call-summary { font-size: 0.9rem; gap: 5px; }
        .call-summary i { font-size: 1.05rem; padding: 2px 4px 2px 1px; }
        .call-date { font-size: 0.8rem; gap: 3px; }
        .call-date i { font-size: 1rem; }
        .call-note { font-size: 0.8rem; margin-top: 10px; padding-right: 6px; }
        .call-note i { font-size: 0.9rem; padding: 1px 4px 1px 1px; }
    }
</style>

<div class="page-wrapper-calls">
    <div class="container">
        @if($lead->calls->count())
            <div class='calls-card'>
                <div class='calls-title'>
                    <i class='bi bi-telephone-outbound'></i>
                    <span>تماس‌های خروجی</span>
                </div>
                <div class='row gy-4'> {{-- gy-4 adds vertical gutter between columns --}}
                    @foreach($lead->calls as $call)
                        <div class='col-12 col-sm-12 col-md-6 col-xl-4 d-flex'> {{-- d-flex makes cards equal height in a row --}}
                            <div class='card call-card w-100 shadow-sm'> {{-- w-100 ensures card takes full column width --}}
                                <div class='corner-bg'></div> {{-- Decorative background element --}}
                                <div class='card-body d-flex flex-column justify-content-center'>
                                    <div class='d-flex align-items-center justify-content-between flex-wrap mb-2'>
                                        <div class='call-summary'>
                                            <i class='bi bi-bookmark-check-fill'></i>
                                            {{ $call->call_summary }}
                                        </div>
                                        <div class='call-date'>
                                            <i class='bi bi-clock'></i>
                                            {{ jdate($call->call_time)->format('Y/m/d H:i') }}
                                        </div>
                                    </div>
                                    @if(!empty($call->notes))
                                        <div class='call-note'>
                                            <i class='bi bi-chat-dots'></i>
                                            {{ $call->notes }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="calls-card text-center py-5">
                <div class="calls-title justify-content-center">
                    <i class='bi bi-telephone-x-fill'></i>
                    <span>تماسی ثبت نشده است</span>
                </div>
                <p class="text-muted mt-3">برای این لید، هیچ سابقه تماسی وجود ندارد.</p>
            </div>
        @endif
    </div>
</div>
@endsection

