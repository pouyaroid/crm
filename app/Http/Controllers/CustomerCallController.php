<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerCall;
use App\Models\CustomerInfo;
use Morilog\Jalali\Jalalian;
use App\Models\Reminder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\ReminderNotification;
use App\Jobs\SendSingleReminderNotification;
use InvalidArgumentException;

class CustomerCallController extends Controller
{
    /**
     * پاکسازی و آماده‌سازی تاریخ شمسی ورودی
     * @param string $jalaliDate
     * @return string
     */
    private function sanitizeJalaliDate($jalaliDate)
    {
        // تبدیل اعداد فارسی و عربی به انگلیسی
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8', '9','0','1','2','3','4','5','6','7','8','9'];
        $jalaliDate = str_replace($persian, $english, $jalaliDate);

        // حذف نام روز هفته (مانند "دوشنبه") و AM/PM
        $jalaliDate = preg_replace('/^[\p{L}\s]+/u', '', $jalaliDate);
        $jalaliDate = preg_replace('/\s*(ق ظ|ب ظ)\s*/u', '', $jalaliDate);

        // اصلاح کلیدی: جایگزینی انواع جداکننده‌ها (فضا، خط تیره، اسلش) با یک اسلش واحد
        $jalaliDate = preg_replace('/[\s\/-]+/', '/', $jalaliDate);

        // تبدیل ماه‌های فارسی به عدد (در صورت وجود)
        $persianMonths = [
            'فروردین' => '1', 'اردیبهشت' => '2', 'خرداد' => '3', 'تیر' => '4',
            'مرداد' => '5', 'شهریور' => '6', 'مهر' => '7', 'آبان' => '8',
            'آذر' => '9', 'دی' => '10', 'بهمن' => '11', 'اسفند' => '12'
        ];
        foreach ($persianMonths as $month => $number) {
            $jalaliDate = str_replace($month, $number, $jalaliDate);
        }

        return $jalaliDate;
    }


    public function index($customerId)
    {
        $customer = CustomerInfo::findOrFail($customerId);
        $calls = $customer->calls()->latest()->get();

        return view('CustomerCall.index', compact('customer', 'calls'));
    }

    public function create($customerId)
    {
        $customer = CustomerInfo::findOrFail($customerId);
        return view('CustomerCall.create', compact('customer'));
    }


    public function store(Request $request, $customerId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'remind_at_jalali' => 'nullable|string',
        ]);

        try {
            $reminder = null;

            DB::transaction(function () use ($request, $customerId, &$reminder) {
                // ثبت تماس
                $call = new CustomerCall();
                $call->customer_info_id = $customerId;
                $call->user_id = Auth::id();
                $call->title = $request->title;
                $call->description = $request->description;
                $call->save();

                // ثبت یادآور (در صورت داشتن تاریخ)
                if ($request->filled('remind_at_jalali')) {
                    // تغییر کلیدی: خط زیر که یک روز از تاریخ کم می‌کرد حذف شد
                    $remindAt = $this->convertJalaliToGregorian($request->remind_at_jalali);

                    $reminder = Reminder::create([
                        'user_id' => Auth::id(),
                        'remindable_id' => $call->id,
                        'remindable_type' => CustomerCall::class,
                        'title' => $request->title,
                        'description' => $request->description,
                        'remind_at' => $remindAt,
                    ]);
                }
            });

            if ($reminder) {
                $now = now();
                $remindAt = $reminder->remind_at;

                // محاسبه اختلاف روزها (مثبت یعنی آینده، صفر یعنی امروز، منفی یعنی گذشته)
                $daysDiff = $now->diffInDays($remindAt, false);

                if ($daysDiff > 0) {
                    // تاریخ ریمایندر در آینده است
                    $delaySeconds = $now->diffInSeconds($remindAt, false);
                    dispatch(new SendSingleReminderNotification($reminder))
                        ->delay(now()->addSeconds($delaySeconds));

                } elseif ($daysDiff === 0) {
                    // تاریخ ریمایندر امروز است => ارسال با تاخیر 12 ساعت
                    $delaySeconds = 12 * 60 * 60; // 12 ساعت به ثانیه
                    dispatch(new SendSingleReminderNotification($reminder))
                        ->delay(now()->addSeconds($delaySeconds));

                } else {
                    // تاریخ ریمایندر گذشته است، نوتیف ارسال نشود
                    Log::info('تاریخ یادآور بیشتر از یک روز گذشته، نوتیف ارسال نشد.', [
                        'now' => $now->toDateTimeString(),
                        'remind_at' => $remindAt->toDateTimeString(),
                    ]);
                }
            }

            return redirect()->route('customer.calls.index', $customerId)
                ->with('success', 'تماس ثبت شد.');

        } catch (\Exception $e) {
            Log::error('خطا در ثبت تماس و یادآوری: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'خطا در ثبت اطلاعات. لطفاً دوباره تلاش کنید.');
        }
    }


    /**
     * تبدیل تاریخ شمسی به Carbon میلادی
     */
    private function convertJalaliToGregorian($jalaliDate)
    {
        try {
            // اطمینان از اینکه تاریخ وارد شده به درستی فرمت شده باشد
            $sanitizedDate = $this->sanitizeJalaliDate($jalaliDate);

            // استخراج اجزای تاریخ و زمان با استفاده از regex
            if (preg_match('/(\d{4})\/(\d{1,2})\/(\d{1,2})/', $sanitizedDate, $matches)) {
                $year = $matches[1];
                $month = $matches[2];
                $day = $matches[3];
            } else if (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{4})/', $sanitizedDate, $matches)) {
                $day = $matches[1];
                $month = $matches[2];
                $year = $matches[3];
            } else {
                throw new InvalidArgumentException("فرمت تاریخ نامعتبر است.");
            }

            // استخراج اجزای زمان با استفاده از regex
            if (preg_match('/(\d{1,2}):(\d{2})/', $sanitizedDate, $timeMatches)) {
                $hour = $timeMatches[1];
                $minute = $timeMatches[2];
            } else {
                // اگر زمان وجود نداشت، به طور پیش‌فرض 00:00 در نظر گرفته شود
                $hour = 0;
                $minute = 0;
            }

            // تبدیل تاریخ شمسی به میلادی با استفاده از سازنده کلاس
            $gregorianDate = (new Jalalian($year, $month, $day, $hour, $minute))->toCarbon();
            
            return $gregorianDate;
        } catch (\Exception $e) {
            // لاگ کردن خطا و پیام دقیقتر
            Log::error('خطا در تبدیل تاریخ شمسی به میلادی:', [
                'input' => $jalaliDate,
                'error' => $e->getMessage()
            ]);
            
            // پرتاب استثنا با پیام بهتر
            throw new InvalidArgumentException('تاریخ یادآور وارد شده نامعتبر است. لطفاً از فرمت صحیح استفاده کنید.');
        }
    }
    public function update(Request $request, $customerId, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'called_at' => 'required|date',
        ]);

        $call = CustomerCall::findOrFail($id);
        $call->update($request->only(['title', 'description', 'called_at']));

        return redirect()->route('customer.calls.index', $customerId)->with('success', 'تماس ویرایش شد.');
    }

    public function destroy($customerId, $id)
    {
        $call = CustomerCall::findOrFail($id);
        $call->delete();

        return redirect()->route('customer.calls.index', $customerId)->with('success', 'تماس حذف شد.');
    }
}
