<!DOCTYPE html>
<html lang='{{ str_replace('_', '-', app()->getLocale()) }}' dir='rtl'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>My App</title>
        
        <!-- Bootstrap RTL CSS -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css'>
        
        <!-- Vazir Font -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@v30.1.0/dist/font-face.css'>
        
        <!-- Styles -->
        <style>
            body {
                font-family: 'Vazir', 'Tahoma', sans-serif;
                background-color: #f8f9fa;
                text-align: right;
            }
            
            .auth-button {
                padding: 0.6rem 1.5rem;
                border-radius: 0.375rem;
                text-decoration: none;
                background: linear-gradient(135deg, #025e3b 0%, #046104 100%);
                color: white;
                transition: all 0.3s ease;
                font-weight: 500;
                border: none;
                box-shadow: 0 4px 6px rgba(255, 45, 32, 0.2);
            }
            
            .auth-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 7px 14px rgba(255, 45, 32, 0.25);
                color: white;
            }
            
            .navbar {
                background-color: white;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            }
            
            .hero-section {
                padding: 120px 0;
                background: linear-gradient(170deg, #ffffff 0%, #f8f9fa 100%);
            }
            
            .hero-title {
                font-weight: 700;
                margin-bottom: 1.5rem;
                color: #343a40;
            }
            
            .hero-subtitle {
                color: #6c757d;
                margin-bottom: 2rem;
            }
            
            .main-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            
            /* RTL specific adjustments */
            .navbar-nav {
                padding-right: 0;
            }
            
            .dropdown-menu {
                text-align: right;
            }
        </style>
    </head>
    <body class='antialiased'>
        <div class='main-container'>
            <!-- Navbar -->
            <nav class='navbar navbar-expand-lg navbar-light py-3'>
                <div class='container'>
                    <a class='navbar-brand fw-bold' href='https://www.kcz.co.com/'>وبسایت ما</a>
                    
                    <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'>
                        <span class='navbar-toggler-icon'></span>
                    </button>
                    
                    <div class='collapse navbar-collapse justify-content-start' id='navbarNav'>
                        @if (Route::has('login'))
                            <div class='d-flex gap-3'>
                                @auth
                                    <a href='{{ url('/dashboard') }}' class='auth-button'>
                                        داشبورد
                                    </a>
                                @else
                                    <a href='{{ route('login') }}' class='auth-button'>
                                        ورود
                                    </a>

                                    @if (Route::has('register'))
                                        <a href='{{ route('register') }}' class='auth-button'>
                                            عضویت
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </nav>
            
            <!-- Hero Section -->
            <section class='hero-section'>
                <div class='container'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-8 text-center'>
                            <h1 class='hero-title'>به سامانه شکایت مشتریان خوش آمدید</h1>
            
                            <div class='d-flex justify-content-center gap-3'>
                                @if (Route::has('login'))
                                    @auth
                                        <a href='{{ url('/dashboard') }}' class='auth-button'>
                                            مشاهده داشبورد
                                        </a>
                                    @else
                                        <a href='{{ route('login') }}' class='auth-button'>
                                            شروع کنید
                                        </a>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Footer -->
            <footer class='bg-light py-4 mt-auto'>
                <div class='container text-center'>
                    <p class='mb-0 text-muted'>© 2025  تمامی حقوق محفوظ است.</p>
                </div>
            </footer>
        </div>
        
        <!-- Bootstrap JS -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    </body>
</html>
