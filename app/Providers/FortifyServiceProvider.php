<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تعیین اکشن‌های Fortify
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // محدودیت لاگین
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        // محدودیت ورود دو مرحله‌ای
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // نمایش فرم لاگین
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // نمایش فرم ثبت‌نام
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // مسیر بعد از ورود موفق
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    return redirect()->intended('/dashboard');
                }
            };
        });

        // مسیر بعد از ثبت‌نام موفق
        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    return redirect('/dashboard');
                }
            };
        });
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });
    }
  
}
