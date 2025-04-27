<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // بررسی نقش‌ها
        if (!in_array($user->role, ['admin', 'sales_agent', 'sales_manager'])) {
            abort(403, 'دسترسی محدود است');
        }

        return $next($request);
    }
// میدلور برای تست
    // Route::middleware(['auth', 'role:accounting'])->group(function () {
    //     Route::get('/accounting/dashboard', [AccountingController::class, 'dashboard'])->name('accounting.dashboard');
    //     Route::get('/accounting/transactions', [AccountingController::class, 'transactions'])->name('accounting.transactions');
    // });
}
