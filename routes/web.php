<?php

use App\Http\Controllers\Admin\FormBuilderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CustomerCaseController;
use App\Http\Controllers\CustomerInfoController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\LeadCallController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadConversionController;
use App\Http\Controllers\LeadReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ipe\Sdk\Facades\SmsIr;
use App\Http\Middleware\CheckUserRole;
use App\Models\CustomerInfo;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Middleware\RoleMiddleware as MiddlewareRoleMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use App\Http\Controllers\ProductTrackingController;
use App\Http\Controllers\PublicFormController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\EventController;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use App\Jobs\SendSingleReminderNotification;
use Illuminate\Support\Facades\Log;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard',[DashboardController::class,'showDashboard'])->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/my-complaints',[ComplaintController::class,'myComplaints'])->name('complaints.my');
    Route::post('/complaint/{id}/rating', [ComplaintController::class, 'storeRating'])->name('complaint.rating');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('complaints.admin.index');
    Route::get('/admin/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::post('/admin/complaints/{complaint}/respond', [ComplaintController::class, 'respondStore'])->name('complaints.response.store');
    Route::put('admin/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.update.status');
    Route::get('/admin/reports', [ComplaintController::class, 'dashboard'])->name('admin.reports');
    Route::get('/admin/reports/7reports',[ComplaintController::class,'dashboardSevenReport'])->name('admin.sevenreports');
    Route::get('/admin/reports/monthreports',[ComplaintController::class,'dashboardMonthReport'])->name('admin.monthreports');
    Route::get('/admin/reports/yearreports',[ComplaintController::class,'dashboardYearReport'])->name('admin.yearreports');
    Route::get('/reports/custom', [ReportController::class, 'showCustomReportForm'])->name('reports.custom.form');
    Route::post('/reports/custom', [ReportController::class, 'generateCustomReport'])->name('reports.custom.generate');
    Route::get('/admin/role/showuser',[RoleController::class,'showRoles']);
    Route::get('/admin/role/index',[RoleController::class,'roleIndex']);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('admin/userslist', [UserController::class, 'index'])->name('users.index');
Route::get('/adminpanel',[AdminController::class,'adminPanel'])->name('admin.panel');
//supervisors
Route::get('/supervisors', [SupervisorController::class, 'index'])->name('supervisors.index');
Route::post('/supervisors', [SupervisorController::class, 'store'])->name('supervisors.store');





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
Route::middleware(['auth', 'role:admin'])->name('shared.')->group(function () {
    Route::get('/saleindex', [SalesController::class, 'index'])->name('index');
});
//route role for indexCustomer
Route::middleware(['auth', 'role:sales_agent|marketing_manager|marketing_user'])->group(function () {
    Route::get('/customers/create',[CustomerInfoController::class,'create'])->name('customers.create');
    Route::post('/customers',[CustomerInfoController::class,'store'])->name('customers.store');
    Route::get('/customers/index', [CustomerInfoController::class, 'index'])->name('customers.index');
    Route::get('/customers/ajax', [CustomerInfoController::class, 'ajax'])->name('customers.ajax');

    // Route::get('/customers/index/{id}', [CustomerInfoController::class, 'index'])->name('customers.show');
    Route::get('/customers/ajax', [CustomerInfoController::class, 'ajax'])->name('customers.ajax');
    Route::get('/customers/{customer}/edit', [CustomerInfoController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [CustomerInfoController::class, 'update'])->name('customers.update');

Route::get('/customers/import', [CustomerInfoController::class, 'importForm'])->name('customers.import.form');
Route::post('/customers/import', [CustomerInfoController::class, 'import'])->name('customers.import');
//for customer calls
Route::get('/customers/{customer}/calls', [\App\Http\Controllers\CustomerCallController::class, 'index'])->name('customer.calls.index');
Route::get('/customers/{customer}/calls/create', [\App\Http\Controllers\CustomerCallController::class, 'create'])->name('customer.calls.create');
Route::post('/customers/{customer}/calls', [\App\Http\Controllers\CustomerCallController::class, 'store'])->name('customer.calls.store');
//رهگییری محصول
Route::get('/tracking/create', [ProductTrackingController::class, 'createTracking'])->name('tracking.create.form');
Route::post('/tracking/store', [ProductTrackingController::class, 'trackingStore'])->name('tracking.store');
Route::get('/tracking', [ProductTrackingController::class, 'index'])->name('tracking.index');
Route::get('/tracking/{productTracking}/edit', [ProductTrackingController::class, 'edit'])->name('tracking.edit');
Route::put('/tracking/{productTracking}', [ProductTrackingController::class, 'update'])->name('tracking.update'); // 
//for mail
Route::get('/customers/message/{id}', [CustomerInfoController::class, 'showMessageForm'])->name('customers.message.single');
Route::post('/customers/message/send', [CustomerInfoController::class, 'sendMessage'])->name('customers.message.send');
//for CaseCustomer
Route::get('customers/{customer}/cases/create', [CustomerCaseController::class, 'create'])->name('cases.create');
Route::post('customers/{customer}/cases', [CustomerCaseController::class, 'store'])->name('cases.store');
Route::get('customers/{customer}/cases', [CustomerCaseController::class, 'index'])->name('customers.cases.index');
Route::post('customers/{customer}/cases', [CustomerCaseController::class, 'store'])->name('customers.cases.store');


// نمایش فرم ارسال پیام تکی
Route::get('/customers/message/{id}', [CustomerInfoController::class, 'showMessageForm'])->name('customers.message.single');
Route::post('/customers/message/single/send', [CustomerInfoController::class, 'sendSingleMessage'])->name('customers.message.single.send');


// نمایش لیست کاربران با چک‌باکس
Route::get('/customers/select', [CustomerInfoController::class, 'showCustomerSelection'])->name('customers.select');

// نمایش فرم نوشتن پیام و ارسال گروهی
Route::post('/customers/message/form', [CustomerInfoController::class, 'showBulkMessageForm'])->name('customers.message.form');

// ارسال ایمیل گروهی
Route::post('/customers/message/send', [CustomerInfoController::class, 'sendBulkMessage'])->name('customers.message.send');


});
//route for manager
Route::middleware(['auth', 'role:sales_agent|sales_manager|admin|sales|management|marketing_manager'])->group(function () {
    Route::get('/customers/create',[CustomerInfoController::class,'create'])->name('customers.create');
    Route::post('/customers',[CustomerInfoController::class,'store'])->name('customers.store');
    Route::get('/customers/index', [CustomerInfoController::class, 'index'])->name('customers.index');
    Route::get('/customers/ajax', [CustomerInfoController::class, 'ajax'])->name('customers.ajax');

    // Route::get('/customers/index/{id}', [CustomerInfoController::class, 'index'])->name('customers.show');
    Route::get('/customers/ajax', [CustomerInfoController::class, 'ajax'])->name('customers.ajax');
    Route::get('/customers/{customer}/edit', [CustomerInfoController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [CustomerInfoController::class, 'update'])->name('customers.update');
Route::delete('/customers/{customer}', [CustomerInfoController::class, 'destroy'])->name('customers.destroy');
Route::get('/customers/export', [CustomerInfoController::class, 'exportCsv'])->name('customers.export');
Route::get('/customers/import', [CustomerInfoController::class, 'importForm'])->name('customers.import.form');
Route::post('/customers/import', [CustomerInfoController::class, 'import'])->name('customers.import');
//for customer calls
Route::get('/customers/{customer}/calls', [\App\Http\Controllers\CustomerCallController::class, 'index'])->name('customer.calls.index');
Route::get('/customers/{customer}/calls/create', [\App\Http\Controllers\CustomerCallController::class, 'create'])->name('customer.calls.create');
Route::post('/customers/{customer}/calls', [\App\Http\Controllers\CustomerCallController::class, 'store'])->name('customer.calls.store');
//رهگییری محصول
Route::get('/tracking/create', [ProductTrackingController::class, 'createTracking'])->name('tracking.create.form');
Route::post('/tracking/store', [ProductTrackingController::class, 'trackingStore'])->name('tracking.store');
Route::get('/tracking', [ProductTrackingController::class, 'index'])->name('tracking.index');
Route::get('/tracking/{productTracking}/edit', [ProductTrackingController::class, 'edit'])->name('tracking.edit');
Route::put('/tracking/{productTracking}', [ProductTrackingController::class, 'update'])->name('tracking.update'); // 
//for mail
Route::get('/customers/message/{id}', [CustomerInfoController::class, 'showMessageForm'])->name('customers.message.single');
Route::post('/customers/message/send', [CustomerInfoController::class, 'sendMessage'])->name('customers.message.send');
//for CaseCustomer
Route::get('customers/{customer}/cases/create', [CustomerCaseController::class, 'create'])->name('cases.create');
Route::post('customers/{customer}/cases', [CustomerCaseController::class, 'store'])->name('cases.store');
Route::get('customers/{customer}/cases', [CustomerCaseController::class, 'index'])->name('customers.cases.index');
Route::post('customers/{customer}/cases', [CustomerCaseController::class, 'store'])->name('customers.cases.store');


// نمایش فرم ارسال پیام تکی
Route::get('/customers/message/{id}', [CustomerInfoController::class, 'showMessageForm'])->name('customers.message.single');
Route::post('/customers/message/single/send', [CustomerInfoController::class, 'sendSingleMessage'])->name('customers.message.single.send');


// نمایش لیست کاربران با چک‌باکس
Route::get('/customers/select', [CustomerInfoController::class, 'showCustomerSelection'])->name('customers.select');

// نمایش فرم نوشتن پیام و ارسال گروهی
Route::post('/customers/message/form', [CustomerInfoController::class, 'showBulkMessageForm'])->name('customers.message.form');

// ارسال ایمیل گروهی
Route::post('/customers/message/send', [CustomerInfoController::class, 'sendBulkMessage'])->name('customers.message.send');


});
//ّForMarketing
Route::middleware(['auth','role:admin|sales_manager|marketing_manager|marketing_user'])->prefix('marketing')->group(function(){
    Route::get('/leadscreate', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads', [LeadController::class, 'leadsStore'])->name('leads.store');
    Route::get('/leads/index', [LeadController::class, 'index'])->name('leads.index');
    
    // مسیرهای Export و Import که به درستی تعریف شده‌اند
    Route::get('/leads/export', [LeadController::class, 'exportCsv'])->name('leads.export');
    Route::get('/leads/import', [LeadController::class, 'importForm'])->name('leads.import.form');
    Route::post('/leads/import', [LeadController::class, 'import'])->name('leads.import');
    
    // سایر مسیرهای شما
    Route::get('/leads/report', [LeadReportController::class, 'index'])->name('leads.report');
    Route::get('leads/{lead}/calls/create', [LeadCallController::class, 'create'])->name('leads.calls.create');
    Route::post('leads/{lead}/calls', [LeadCallController::class, 'store'])->name('leads.calls.store');
    Route::get('leads/{lead}', [LeadCallController::class, 'show'])->name('leads.show');
    Route::get('leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
    Route::post('/leads/{id}/convert', [LeadConversionController::class, 'convert'])->name('leads.convert');

});
   






Route::get('/tracking/search', function () {
    return view('ProductTracking.search');
})->name('tracking.search');
//روت هایی که نیاز به لاگین ندارند
Route::post('/tracking/search', [ProductTrackingController::class, 'search'])->name('product.tracking.search');
//Todo

Route::middleware(['auth', 'role:sales_agent|employee|admin|supervisor|marketing_manager|marketing_user'])->group(function () {
   
    
    // Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    // Route::get('/todos/user/{user}', [TodoController::class, 'userTodos'])->name('todos.user');

    // Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('todos.show');
    // Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
    // Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    // Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
});

//notif
Route::get('/notifications', function () {
    $notifications = auth()->user()->notifications;
    return view('notifications.index', compact('notifications'));
})->name('notifications.index')->middleware('auth');

Route::get('/notifications/mark/{id}', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark');


Route::get('/notifications/mark/{id}', function ($id, Request $request) {
    $notification = $request->user()->notifications()->where('id', $id)->first();
    if ($notification) {
        $notification->markAsRead();
        // اینجا می‌تونی به مسیر قبلی یا صفحه موردنظر ریدایرکت کنی
        return redirect()->back()->with('success', 'اعلان خوانده شد.');
    }
    return redirect()->back()->with('error', 'اعلان پیدا نشد.');
})->name('notifications.mark');

Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::get('/todos/user/{user}', [TodoController::class, 'userTodos'])->name('todos.user');

Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('todos.show');
Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::patch('/todos/{id}/done', [TodoController::class, 'markAsDone'])->name('todos.done');



Route::get('/test-email', function () {
    Mail::raw('تست ارسال ایمیل لاراول', function ($message) {
        $message->to('receiver@example.com')->subject('ایمیل تستی');
    });

    return 'ایمیل ارسال شد (در صورت تنظیم درست).';
});
Route::middleware(['auth'])->group(function () {
    
    // مسیرهای مربوط به رویدادها

    // نمایش لیست تمام رویدادها
    Route::get('/events', [EventController::class, 'index'])->name('events.index');

    // نمایش فرم ایجاد رویداد جدید
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

    // ذخیره رویداد جدید در دیتابیس
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // نمایش فرم ویرایش یک رویداد خاص
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');

    // به‌روزرسانی اطلاعات یک رویداد خاص در دیتابیس
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');

    // حذف یک رویداد خاص
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
     // مسیر اصلی برای نمایش لیست یا تقویم
     Route::get('/events', [EventController::class, 'index'])->name('events.index');
     // مسیر API برای دریافت رویدادها
     Route::get('/events/api', [EventController::class, 'apiEvents'])->name('events.api');
     Route::get('/events/calendar', [EventController::class, 'showCalendar'])->name('events.calendar');

});
//testReminder
Route::get('/test-reminder', function (\Illuminate\Http\Request $request) {
    $jalaliDate = $request->query('date', '1404/05/20 10:00'); // تاریخ جلالی پیش‌فرض

    // تبدیل تاریخ جلالی به میلادی
    try {
        $remindAt = Jalalian::fromFormat('Y/m/d H:i', $jalaliDate)->toCarbon()->subDay();
    } catch (\Exception $e) {
        return response()->json(['error' => 'فرمت تاریخ جلالی نامعتبر است.', 'message' => $e->getMessage()], 400);
    }

    $now = now();
    $daysDiff = $now->diffInDays($remindAt, false);
    $delaySeconds = $now->diffInSeconds($remindAt, false);

    if ($daysDiff > 0) {
        $status = 'تاریخ آینده است، نوتیف با تاخیر ارسال می‌شود.';
    } elseif ($daysDiff === 0) {
        $status = 'تاریخ امروز است، نوتیف ۱۲ ساعت بعد ارسال می‌شود.';
        $delaySeconds = 12 * 60 * 60; // 12 ساعت به ثانیه
    } else {
        $status = 'تاریخ گذشته است، نوتیف ارسال نمی‌شود.';
    }

    return response()->json([
        'status' => $status,
        'now' => $now->toDateTimeString(),
        'remind_at' => $remindAt->toDateTimeString(),
        'days_diff' => $daysDiff,
        'delay_seconds' => $delaySeconds,
    ]);
});