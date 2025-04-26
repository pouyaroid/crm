<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ipe\Sdk\Facades\SmsIr;
use App\Http\Middleware\CheckUserRole;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard',[DashboardController::class,'showDashboard'])->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/my-complaints',[ComplaintController::class,'myComplaints'])->name('complaints.my');
    Route::post('/complaint/{id}/rating', [ComplaintController::class, 'storeRating'])->name('complaint.rating');
});
Route::middleware(['auth', CheckUserRole::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::post('/admin/complaints/{complaint}/respond', [ComplaintController::class, 'respondStore'])->name('complaints.response.store');
    Route::put('admin/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.update.status');
    Route::get('/admin/reports', [ComplaintController::class, 'dashboard'])->name('admin.reports');
    Route::get('/admin/reports/7reports',[ComplaintController::class,'dashboardSevenReport'])->name('admin.sevenreports');
    Route::get('/admin/reports/monthreports',[ComplaintController::class,'dashboardMonthReport'])->name('admin.monthreports');
    Route::get('/admin/reports/yearreports',[ComplaintController::class,'dashboardYearReport'])->name('admin.yearreports');
    Route::get('/reports/custom', [ReportController::class, 'showCustomReportForm'])->name('reports.custom.form');
Route::post('/reports/custom', [ReportController::class, 'generateCustomReport'])->name('reports.custom.generate');
});
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login'); // بعد از لاگ‌اوت بره صفحه لاگین
})->name('logout');

Route::get('/test-sms', function () {
   

    // $lineNumber = "30002108000573"; // شماره خط فرستنده
    // $messageText = "این یک پیام آزمایشی است.";
    // $mobiles = ["09385347786", "09191552429"]; // لیست شماره‌های گیرنده
    // $sendDateTime = null;   // برای ارسال آنی، مقدار را نال قرار دهید
    
    // $response = SmsIr::bulkSend($lineNumber, $messageText, $mobiles, $sendDateTime);


$mobile = "09385347786"; // شماره موبایل گیرنده
$templateId = 123456; // شناسه الگو
$parameters = [    
[        
   "name" => "Code",        
   "value" => "123456"    ]
];

$response = SmsIr::verifySend($mobile, $templateId, $parameters);
dd($response);

});

// sms()->via('farazsmspattern')->to('09385347786')->send("patterncode=yadpxx4l9rl84ku");
