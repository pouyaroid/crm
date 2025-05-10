{{-- Font Vazir & Bootstrap Icons --}}
<link href='https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css' rel='stylesheet' type='text/css' />
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css'>

{{-- Calls Card Modern Styles --}}
<style>
    body, .vazir { font-family: Vazir, Tahoma, Arial, sans-serif !important; direction: rtl; background: #f8fafc; }
    .calls-card {
        background: linear-gradient(135deg, #f3f8fe 90%, #e6f2ff 100%);
        border-radius: 26px;
        box-shadow: 0 2px 44px #bad8ff44, 0 1.5px 10px #d4e8fd66;
        border: none;
        padding: 48px 36px 32px 36px;
        margin-bottom: 36px;
    }
    .calls-title {
        color: #2475f2;
        font-weight: 900;
        font-size: 1.28rem;
        letter-spacing: -0.5px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        user-select: none;
    }
    .calls-title i {
        background: linear-gradient(120deg,#e5eeff,#dbe9fe 56%,#97cafd 84%);
        color: #1875f0;
        border-radius: 12px;
        font-size: 2.05rem;
        padding: 6px 11px 6px 6px;
        box-shadow: 0 2px 12px #c3e5ff32;
        transition: background 0.25s;
    }
    .call-card {
        background: linear-gradient(110deg, #ffffff 96%, #f0f7ff 100%);
        border-radius: 20px;
        box-shadow: 0 3px 20px #d3e7fa55, 0 1.5px 8px #dcedfe60;
        transition: all 0.30s cubic-bezier(.22,.68,.51,1.26);
        min-height: 132px;
        position: relative;
        overflow: hidden;
        border: none;
        border-right: 4px solid transparent;
        outline: 0;
        /* Glamorous small border for status could add here. */
    }
    .call-card:hover {
        box-shadow: 0 7px 28px #a6d1fc66, 0 1.5px 12px #99c9fa77;
        transform: translateY(-6px) scale(1.032);
        background: linear-gradient(107deg, #fafdff 89%, #e4f2ff 100%);
        border-right: 4px solid #217ad9;
    }
    .call-summary {
        font-size: 1.1rem;
        color: #2576dd;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap:8px;
    }
    .call-summary i {
        font-size: 1.28rem;
        background: #e7f4ff;
        color: #49b0ff;
        border-radius: 8px;
        padding: 3.5px 4.5px 3.5px 2.5px;
        margin-left: 3px;
    }
    .call-date {
        font-size: 1.01rem;
        color: #929eb7;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 400;
    }
    .call-date i {
        font-size: 1.12rem;
    }
    .call-note {
        font-size: 1.01rem;
        color: #527097;
        margin-top: 13px;
        display: flex;
        align-items: flex-start;
        gap: 7px;
        border-right: 2.5px solid #dfedfe;
        padding-right: 8px;
        background: #f7fbff;
        border-radius: 7px;
    }
    .call-note i {
        color: #64bdee;
        background: #e1f2fe;
        border-radius: 8px;
        font-size: 1.09rem;
        padding: 2px 6px 2px 2px;
        margin-left: 3.5px;
    }
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
    .call-card .card-body {
        position: relative;
        z-index: 1;
    }
    /* Divider between cards (optional visual improvement) */
    .calls-card .call-card:not(:last-child) { margin-bottom: 18px; }
    @media (max-width: 991px) {
        .calls-card { padding: 26px 7vw 20px 7vw; }
        .call-card { min-height: 115px; }
    }
    @media (max-width: 576px) {
        .calls-card { padding: 12px 2vw 8px 2vw; }
        .call-card { min-height: 99px;}
        .call-summary { font-size: 1rem; }
        .call-date { font-size: 0.93rem; }
        .call-note { font-size: 0.92rem; }
        .calls-title i { font-size: 1.38rem;}
    }
</style>
@if($lead->calls->count())
    <div class='vazir'>
        <div class='calls-card'>
            <div class='calls-title'>
                <i class='bi bi-telephone-outbound'></i>
                <span>تماس‌های خروجی</span>
            </div>
            <div class='row gy-4'>
                @foreach($lead->calls as $call)
                    <div class='col-12 col-sm-12 col-md-6 col-xl-4 d-flex'>
                        <div class='card call-card w-100 shadow-sm mb-2'>
                            <div class='corner-bg'></div>
                            <div class='card-body d-flex flex-column justify-content-center h-100'>
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
    </div>
@else
    <div class="vazir">
        <div class="calls-card text-center py-5">
            <div class="calls-title justify-content-center">
                <i class='bi bi-telephone-x-fill'></i>
                <span>تماسی ثبت نشده است</span>
            </div>
        </div>
    </div>
@endif
