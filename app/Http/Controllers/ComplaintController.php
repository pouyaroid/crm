<?php

namespace App\Http\Controllers;
use Morilog\Jalali\Jalalian;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ComplaintImage;
use App\Models\ComplaintResponse;
use App\Notifications\ComplaintSubmitted;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'ordernumber' => 'required|integer',
                'title' => 'required|max:50',
                'description' => 'required|min:10',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:20480',
            ]);
            $shamsiDate = Jalalian::now()->format('Y-m-d H:i:s');
            
    
            $complaint = Complaint::create([
                'user_id' => auth()->id(),
                'ordernumber' => $data['ordernumber'],
                'title' => $data['title'],
                'description' => $data['description'],
                'created_at_shamsi' => \Morilog\Jalali\Jalalian::now()->format('Y-m-d'), // تاریخ شمسی
            ]);
    
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('complaint_images', 'public');
                    ComplaintImage::create([
                        'complaint_id' => $complaint->id,
                        'path' => $path
                    ]);
                }
            }
    
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('complaint_videos', 'public');
                $complaint->update([
                    'video_path' => $videoPath
                ]);
            }
    
            auth()->user()->notify(new ComplaintSubmitted($complaint));

            return redirect()->back()->with('success', 'شکایت با موفقیت ثبت شد و ایمیل تایید ارسال شد.');
    
        } catch (\Exception $e) {
            \Log::error('خطا در ثبت شکایت: ' . $e->getMessage());

            return redirect()->back()->with('error', 'خطایی در ثبت شکایت رخ داد.');
        }
        // ارسال ایمیل به کاربر
  
    }
    

    public function index(Request $request)
    {
        $user = auth()->user();
         
        
        $query = Complaint::with(['user', 'images', 'response']);
    
        // 🎯 شرط بر اساس نقش
        if ($user->role === 'sales_agent') {
            // فقط شکایت‌هایی که کاربر آنها sales_agent_id ش برابر با ID لاگین‌شده است
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('sales_agent_id', $user->id);
            });
        } elseif ($user->role === 'sales_manager') {
            // فقط شکایت‌هایی که خودش به عنوان کاربر ثبت کرده
            $query->where('user_id', $user->id);
        }
        // اگر admin باشه، هیچ فیلتری نیاز نیست
    
        // 🎯 فیلتر جستجو
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
    
        if ($request->filled('ordernumber')) {
            $query->where('ordernumber', 'like', '%' . $request->ordernumber . '%');
        }
    
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        
    
        $complaints = $query->latest()->paginate(10);
    
        return view('admin.complaints.index', compact('complaints'));
        
}
    public function myComplaints()
{
    $user = auth()->user();

    $complaints = Complaint::where('user_id', $user->id)
        ->with(['images', 'response'])
        ->latest()
        ->paginate(10);

    return view('auth.my', compact('complaints'));
}
    public function respondStore(Request $request, Complaint $complaint ){
     $request->validate([
        'response' => 'required|string|max:500',
        
    ]);
    
    if ($complaint->response) {
        $complaint->response->update([
            'response' => $request->response,
        ]);
       
    } else {
        $complaint->response()->create([
            'response' => $request->response,
        ]);
    }

    return redirect()->back()->with('success', 'پاسخ با موفقیت ثبت شد.');
 }
 public function updateStatus(Request $request, Complaint $complaint)
{
    $request->validate([
        'status' => 'required|in:new,in_progress,answered,closed,rejected',
    ]);
    

    $complaint->status = $request->status;
    $complaint->save();

    return back()->with('success', 'وضعیت شکایت با موفقیت بروزرسانی شد.');
}
public function dashboard()
{
    $statusCounts = Complaint::selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status');

    return view('admin.complaints.reports.reports', compact('statusCounts'));
    
}
public function dashboardSevenReport (){
    $last7DaysCounts = Complaint::selectRaw('status, COUNT(*) as count')
        ->whereBetween('created_at', [now()->subDays(7), now()])
        ->groupBy('status')
        ->pluck('count', 'status');
    return view('admin.complaints.reports.sevendaysreaports',compact('last7DaysCounts'));    
}
public function dashboardMonthReport(){
    $last30DaysCounts = Complaint::selectRaw('status, COUNT(*) as count')
        ->whereBetween('created_at', [now()->subDays(30), now()])
        ->groupBy('status')
        ->pluck('count', 'status');
        return view('admin.complaints.reports.monthreports',compact('last30DaysCounts'));
}
public function dashboardYearReport(){
    $lastYearCounts = Complaint::selectRaw('status, COUNT(*) as count')
    ->whereBetween('created_at', [now()->subDays(365), now()])
    ->groupBy('status')
    ->pluck('count', 'status');
    return view('admin.complaints.reports.yearreports',compact('lastYearCounts'));


}
public function storeRating(Request $request, $id)
{
    // پیدا کردن شکایت
    $complaint = Complaint::findOrFail($id);

    // اعتبارسنجی ورودی
    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
    ]);

    // ذخیره امتیاز در پایگاه داده
    $complaint->rating = $validated['rating'];
    $complaint->save();

    // بازگشت به صفحه شکایت با پیغام موفقیت
    return redirect()->route('complaints.my', $id)->with('status', 'امتیاز شما با موفقیت ثبت شد.');
}
}


 

 