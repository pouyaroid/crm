// ...
public function boot(): void
{
    // ...
    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // این بخش برای روت‌های web شماست
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}
// ...