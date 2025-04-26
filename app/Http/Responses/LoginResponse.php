<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        return redirect()->intended('/dashboard'); // 👈 اینجا مسیر بعد از لاگین رو مشخص می‌کنی
    }
}
