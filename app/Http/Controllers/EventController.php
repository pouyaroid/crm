<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // اضافه کردن مدل Event
use Morilog\Jalali\Jalali; // اضافه کردن پکیج Jalali
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

class EventController extends Controller
{
    public function index()
    {
        // بررسی نقش کاربر برای نمایش رویدادها
        if (auth()->user()->hasRole(['admin', 'marketing manager', 'sales manager'])) {
            $events = Event::with('user')->get();
        } else {
            $events = auth()->user()->events()->get();
        }
        
        // تبدیل تاریخ‌های میلادی به شمسی برای نمایش در Frontend
        $events->each(function ($event) {
            // بررسی می‌کنیم که فیلد event_date یک نمونه معتبر از Carbon باشد و همچنین isValid باشد
            if ($event->event_date instanceof Carbon && $event->event_date->isValid()) {
                $event->event_date_jalali = Jalalian::fromCarbon($event->event_date)->format('Y/m/d');
            } else {
                $event->event_date_jalali = 'تاریخ نامعتبر';
            }
            
            // بررسی می‌کنیم که فیلد end_date یک نمونه معتبر از Carbon باشد و همچنین isValid باشد
            if ($event->end_date instanceof Carbon && $event->end_date->isValid()) {
                $event->end_date_jalali = Jalalian::fromCarbon($event->end_date)->format('Y/m/d');
            } else {
                $event->end_date_jalali = 'ندارد';
            }
        });
        
        return view('events.index', compact('events'));
    }

    /**
     * نمایش فرم ایجاد رویداد جدید.
     */
    public function create()
    {
        // بررسی دسترسی کاربر به ایجاد رویداد
        // از Middleware در مسیرها استفاده می‌شود، اما می‌توان در اینجا نیز بررسی کرد.
        return view('events.create');
    }

    /**
     * ذخیره رویداد جدید در دیتابیس.
     */
    public function store(Request $request)
    {
        // تابع کمکی برای تبدیل ارقام فارسی به انگلیسی
        function convertPersianToEnglishDigits($input)
        {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            return str_replace($persian, $english, $input);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'event_date_jalali' => 'required|string',
            'end_date_jalali' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // تبدیل تاریخ شمسی به میلادی پس از تبدیل ارقام
        $eventStartDateJalali = convertPersianToEnglishDigits($request->input('event_date_jalali'));
        $eventStartDateCarbon = Jalalian::fromFormat('Y/m/d', $eventStartDateJalali)->toCarbon();
        
        $eventEndDateCarbon = null;
        if ($request->filled('end_date_jalali')) {
            $eventEndDateJalali = convertPersianToEnglishDigits($request->input('end_date_jalali'));
            $eventEndDateCarbon = Jalalian::fromFormat('Y/m/d', $eventEndDateJalali)->toCarbon();
        }

        auth()->user()->events()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'event_date' => $eventStartDateCarbon,
            'end_date' => $eventEndDateCarbon,
        ]);

        return redirect()->route('events.index')->with('success', 'رویداد با موفقیت ایجاد شد.');
    }

    /**
     * نمایش فرم ویرایش یک رویداد.
     */
    public function edit(Event $event)
    {
        // بررسی دسترسی کاربر: فقط ایجادکننده یا ادمین می‌تواند ویرایش کند
        if (auth()->user()->id !== $event->user_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'شما اجازه دسترسی به این صفحه را ندارید.');
        }

        // تبدیل تاریخ‌های میلادی به شمسی برای نمایش در فرم
        $event->event_date_jalali = \Morilog\Jalali\Jalalian::fromCarbon($event->event_date)->format('Y/m/d');
        if ($event->end_date) {
            $event->end_date_jalali = \Morilog\Jalali\Jalalian::fromCarbon($event->end_date)->format('Y/m/d');
        }

        return view('events.edit', compact('event'));
    }

    /**
     * به‌روزرسانی رویداد.
     */
    public function update(Request $request, Event $event)
    {
        // بررسی دسترسی کاربر
        if (auth()->user()->id !== $event->user_id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'event_date_jalali' => 'required|string',
            'end_date_jalali' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // تبدیل تاریخ شمسی به میلادی
        $eventStartDateCarbon = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $request->input('event_date_jalali'))->toCarbon();
        
        $eventEndDateCarbon = null;
        if ($request->filled('end_date_jalali')) {
            $eventEndDateCarbon = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $request->input('end_date_jalali'))->toCarbon();
        }
        
        // به‌روزرسانی رویداد
        $event->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'event_date' => $eventStartDateCarbon,
            'end_date' => $eventEndDateCarbon,
        ]);

        return redirect()->route('events.index')->with('success', 'رویداد با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف یک رویداد.
     */
    public function destroy(Event $event)
    {
        // بررسی دسترسی کاربر: فقط ایجادکننده یا ادمین می‌تواند حذف کند
        if (auth()->user()->id !== $event->user_id && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $event->delete();
        
        return redirect()->route('events.index')->with('success', 'رویداد با موفقیت حذف شد.');
    }
    public function apiEvents()
    {
        // اعمال همان منطق دسترسی متد index
        if (auth()->user()->hasRole(['admin', 'marketing manager', 'sales manager'])) {
            $events = Event::all();
        } else {
            $events = auth()->user()->events;
        }

        // تبدیل رویدادها به فرمت JSON مورد نیاز FullCalendar
        $formattedEvents = $events->map(function ($event) {
            $end_date = null;
            if ($event->end_date instanceof Carbon && $event->end_date->isValid()) {
                $end_date = Jalalian::fromCarbon($event->end_date)->format('Y-m-d');
            }
            
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => Jalalian::fromCarbon($event->event_date)->format('Y-m-d'),
                'end' => $end_date,
            ];
        });

        return response()->json($formattedEvents);
    }
}
