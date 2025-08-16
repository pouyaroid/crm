@extends('layouts.app')

@section('title', 'خوش آمدید')

@push('styles')
    {{-- فونت وزیر از CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.003.02/fonts/variable/Vazirmatn-RD.min.css" rel="stylesheet">
    {{-- Animate.css برای انیمیشن‌ها --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            direction: rtl;
            background: linear-gradient(135deg, #f9f9fb, #f1f3f6);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .welcome-wrapper {
            width: 100%;
            max-width: 700px;
            padding: 2rem;
        }
        .welcome-card {
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem 2rem;
            text-align: center;
            overflow: hidden;
            position: relative;
        }
        .welcome-icon {
            font-size: 4rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
        .welcome-title {
            font-size: 2.2rem;
            font-weight: bold;
            color: #212529;
        }
        .welcome-text {
            font-size: 1.1rem;
            color: #495057;
            margin-top: 1rem;
        }
        /* انیمیشن‌های سفارشی */
        .float-shape {
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(13, 110, 253, 0.08);
            animation: float 6s ease-in-out infinite;
            z-index: 0;
        }
        .float-shape.shape1 {
            top: -30px; left: -30px;
        }
        .float-shape.shape2 {
            bottom: -40px; right: -40px;
            animation-delay: 3s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @media (max-width: 576px) {
            .welcome-card {
                padding: 2rem 1.5rem;
            }
            .welcome-title {
                font-size: 1.6rem;
            }
            .welcome-text {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="welcome-wrapper">
        <div class="welcome-card animate__animated animate__fadeInDown animate__faster">
            
            {{-- اشکال شناور --}}
            <div class="float-shape shape1"></div>
            <div class="float-shape shape2"></div>

            {{-- آیکون --}}
            <div class="welcome-icon animate__animated animate__bounceIn">
                <i class="bi bi-stars"></i>
            </div>

            {{-- عنوان --}}
            <h1 class="welcome-title animate__animated animate__fadeInUp animate__delay-1s">
                کاربر گرامی {{ auth()->user()->name }} خوش آمدید 🌟
            </h1>

            {{-- متن توضیحی --}}
            <p class="welcome-text animate__animated animate__fadeIn animate__delay-2s">
                برای استفاده از نرم‌افزار <span class="text-primary fw-bold">رُشد</span>  
                از پنل کناری استفاده کنید.
            </p>

           
    </div>
@endsection
