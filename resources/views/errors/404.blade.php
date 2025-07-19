
<link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn-font/dist/font-face.css" rel="stylesheet" />

<style>
body, .error-bg, .error-box, .err-404, .error-title, .error-desc, .error-btn {
    font-family: 'Vazirmatn', 'Vazir', Tahoma, sans-serif !important;
}
.error-bg {
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at 50% 30%, #b4f7d6 0%, #43e97b 100%);
}
.error-box {
    background: rgba(255,255,255,0.97);
    box-shadow: 0 6px 48px 8px rgba(67, 233, 123, 0.10), 0 3px 28px #88efbc;
    border-radius: 2rem;
    padding: 3rem 2rem 2.8rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    min-width: 340px;
    max-width: 440px;
}

.err-404 {
    font-size: 7rem;
    font-weight: 900;
    letter-spacing: .13em;
    color: #e0ffe6;
    -webkit-text-stroke: 2.2px #43e979;
    animation: pop-in 1s cubic-bezier(.35,1.36,.5,1) 0.09s backwards;
}

@keyframes pop-in {
    0% {opacity:0;transform: scale(0.5);}
    80%{transform:scale(1.11)}
    100% {opacity:1;transform: scale(1);}
}

.error-rocket {
    animation: floating 2.35s infinite cubic-bezier(.4,0,.6,1) alternate;
    margin-bottom: 2.5rem;
    width: 99px;
    height: 99px;
}

@keyframes floating {
    0%{transform:translateY(0) rotate(-6deg);}
    100%{transform:translateY(-14px) rotate(8deg);}
}

.error-title {
    font-size: 2.1rem;
    font-weight: bold;
    color: #27b76a;
    margin-bottom: 0.4rem;
    letter-spacing: .04em;
    animation: fadeIn 1.7s .7s backwards;
}
@keyframes fadeIn {
    0%{opacity:0;transform:translateY(28px);}
    100%{opacity:1;transform:none;}
}
.error-desc {
    color: #227755;
    font-size: 1.09rem;
    margin-bottom: 1.9rem;
    animation: fadeIn 1.8s 1.0s backwards;
}

.error-btn {
    display: inline-block;
    background: linear-gradient(92deg,#42e97d 6%, #27b76a 99%);
    color: #fff;
    padding: .75rem 2.6rem;
    border: none;
    border-radius: 45px;
    font-size: 1.15rem;
    font-weight: 700;
    transition: box-shadow .3s, transform .18s;
    cursor: pointer;
    box-shadow: 0 3px 36px 0 rgba(40,200,120,.12);
    position: relative;
    z-index: 1;
    animation: fadeIn 2s 1.3s backwards;
    font-family: inherit;
}
.error-btn:hover {
    box-shadow: 0 8px 24px 0 #63efa638;
    transform: translateY(-2px) scale(1.05) rotate(-1.5deg);
    background: linear-gradient(87deg, #82e5bb 10%, #1baa5d 100%);
    color: #fff;
}

@media (max-width:480px){
    .error-box{
        padding:2.2rem 0.6rem 1.5rem;
        min-width:0;
    }
    .err-404{font-size:4.6rem;}
    .error-title{font-size:1.25rem;}
}
</style>
<div class="error-bg">
    <div class="error-box shadow-lg">
        <svg class="error-rocket" viewBox="0 0 74 74" fill="none">
            <ellipse cx="37" cy="61" rx="32" ry="7" fill="#d3f5cb" />
            <g>
                <rect x="33.6" y="19.5" width="6.8" height="23.5" rx="3.4" fill="#27b76a" />
                <rect x="33.7" y="14.8" width="6.6" height="11.1" rx="3.3" fill="#42e97d"/>
                <rect x="35.8" y="6.6" width="2.4" height="13.2" rx="1.2" fill="#b4f7d6"/>
            </g>
            <ellipse cx="37" cy="55.5" rx="4.5" ry="6" fill="#82e5bb"/>
            <ellipse cx="37" cy="41.5" rx="2.5" ry="2.5" fill="#fff"/>
        </svg>
        <span class="err-404">404</span>
        <div class="error-title">صفحه‌ای که دنبالش بودید پیدا نشد!</div>
        <div class="error-desc">امکان دارد این صفحه حذف یا جابجا شده باشد.<br>یا نشانی را اشتباه وارد کرده‌اید.</div>
        <a href="{{ url('/') }}" class="error-btn">بازگشت به خانه</a>
    </div>
</div>

