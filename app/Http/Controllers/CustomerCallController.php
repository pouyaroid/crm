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

class CustomerCallController extends Controller
{
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
                $remindAt = $this->convertJalaliToGregorian($request->remind_at_jalali)
                                 ->subDay(); // یک روز قبل

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

        return redirect()->route('customers.calls.index', $customerId)
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
        $raw = trim($jalaliDate);
        $raw = preg_replace('/\x{200C}/u', '', $raw); // حذف کاراکترهای نامرئی
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
        $date = str_replace($persian, $english, $raw);
        $date = preg_replace('/[.\-،\s]+/u', '/', $date);
        $date = preg_replace('#/+#', '/', $date);

        $formats = [
            'Y/m/d H:i:s', 'Y/m/d H:i', 'Y/m/d',
            'Y/n/j H:i:s', 'Y/n/j H:i', 'Y/n/j'
        ];

        foreach ($formats as $fmt) {
            try {
                return Jalalian::fromFormat($fmt, $date)->toCarbon();
            } catch (\Exception $e) {
                continue;
            }
        }

        Log::error('تاریخ یادآور نامعتبر است', ['input' => $jalaliDate, 'normalized' => $date]);
        throw new \InvalidArgumentException('تاریخ یادآور وارد شده نامعتبر است.');
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

        return redirect()->route('customers.calls.index', $customerId)->with('success', 'تماس ویرایش شد.');
    }

    public function destroy($customerId, $id)
    {
        $call = CustomerCall::findOrFail($id);
        $call->delete();

        return redirect()->route('customers.calls.index', $customerId)->with('success', 'تماس حذف شد.');
    }
}



