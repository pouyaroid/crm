<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian; // این خط را نگه دارید، ممکن است در بخش نمایش تاریخ شمسی استفاده شود.

class TodoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $todos = collect();
        $users = collect();

        if ($user->hasRole('admin')) {
            $todos = Todo::with('user')->latest()->get();
            $users = User::with('todos')->get();
        } elseif ($user->hasRole('supervisor')) {
            $subordinateIds = $user->subordinates->pluck('id')->toArray();
            $allowedUserIds = array_merge([$user->id], $subordinateIds);

            $todos = Todo::whereIn('user_id', $allowedUserIds)->with('user')->latest()->get();
            $users = User::whereIn('id', $allowedUserIds)->with('todos')->get();
        } else {
            $todos = Todo::where('user_id', $user->id)->with('user')->latest()->get();
        }

        return view('todos.index', compact('todos', 'users'));
    }

    public function create()
    {
        $user = auth()->user();
        $users = collect();

        if ($user->hasRole('admin')) {
            $users = User::all();
        } elseif ($user->hasRole('supervisor')) {
            $subordinateIds = $user->subordinates->pluck('id')->toArray();
            $allowedUserIds = array_merge([$user->id], $subordinateIds);
            $users = User::whereIn('id', $allowedUserIds)->get();
        }

        return view('todos.create', compact('users'));
    }

    public function store(Request $request)
    {
        // تغییرات: 'due_date' به nullable|date_format:Y-m-d H:i:s
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string', // اضافه شده از متد update
            'due_date' => 'nullable|date_format:Y-m-d H:i:s', 
            // در صورت وجود نقش، user_id هم بررسی می‌شود
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $todo = new Todo();
        $todo->title = $validated['title'];
        $todo->description = $validated['description'] ?? null; // اضافه شده از متد update

        // منطق تعیین user_id بر اساس نقش
        $currentUser = Auth::user();
        if ($currentUser->hasRole('admin') || $currentUser->hasRole('supervisor')) {
            // اگر user_id ارسال شده بود، از آن استفاده کن، در غیر این صورت به کاربر فعلی اختصاص بده
            $todo->user_id = $request->input('user_id', $currentUser->id);
        } else {
            $todo->user_id = $currentUser->id; // کاربر عادی فقط برای خودش تسک ثبت می‌کند
        }
        
        // **اینجا نقطه کلیدی است:** تاریخ میلادی را مستقیماً از ورودی دریافت می‌کنیم
        $todo->due_date = $request->input('due_date'); // از قبل میلادی و با فرمت صحیح است.
        
        // مقدار is_done (اگر در فرم store هم استفاده می‌شود)
        $todo->is_done = $request->has('is_done') ? 1 : 0; // پیش‌فرض 0، اگر در فرم store چک‌باکس دارید

        $todo->save();

        return redirect()->back()->with('success', 'کار جدید ثبت شد.');
    }

    public function update(Request $request, Todo $todo)
    {
        $currentUser = Auth::user();
    
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date_format:Y-m-d H:i:s', // این اعتبارسنجی صحیح است
            'is_done' => 'boolean', 
        ];
    
        if ($currentUser->hasRole('admin') || $currentUser->hasRole('supervisor')) {
            $rules['user_id'] = 'required|exists:users,id';
        }
    
        $request->validate($rules);
    
        $userId = $currentUser->hasRole('admin') || $currentUser->hasRole('supervisor')
            ? $request->input('user_id')
            : $currentUser->id; // این خط صحیح است
    
        $miladiDateTime = $request->input('due_date'); // تاریخ میلادی با ارقام انگلیسی از فرانت‌اِند می‌آید.
    
        $isDone = $request->has('is_done') ? 1 : 0; // این خط صحیح است
    
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $miladiDateTime, 
            'user_id' => $userId,
            'is_done' => $isDone,
        ]);
    
        return redirect()->back()->with('success', 'تسک با موفقیت ویرایش شد.');
    }

    public function show(Todo $todo)
    {
        $this->authorizeView($todo);
        return view('todos.show', compact('todo'));
    }

    public function destroy(Todo $todo)
    {
        $this->authorizeView($todo);
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'تسک حذف شد.');
    }

    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        $user = auth()->user(); // کاربر فعلی

        $users = collect(); // مقداردهی اولیه به یک کالکشن خالی
        if ($user->hasRole('admin')) {
            $users = User::all(); // ادمین به همه کاربران دسترسی دارد
        } elseif ($user->hasRole('supervisor')) {
            // سرپرست به خودش و زیرمجموعه‌هایش دسترسی دارد
            $subordinateIds = $user->subordinates->pluck('id')->toArray();
            $allowedUserIds = array_merge([$user->id], $subordinateIds);
            $users = User::whereIn('id', $allowedUserIds)->get();
        }
        // کاربر عادی نیازی به لیست کاربران ندارد، چون فقط تسک خودش را ویرایش می‌کند

        if ($user->hasRole('admin') || $user->hasRole('supervisor') || $user->id == $todo->user_id) {
            return view('todos.edit', compact('todo', 'users')); // ارسال $users به ویو
        }

        abort(403, 'شما اجازه دسترسی به این صفحه را ندارید.');
    }

    public function userTodos(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'شما دسترسی ندارید.');
        }

        $todos = $user->todos()->latest()->paginate(10);
        return view('todos.user_todos', compact('user', 'todos'));
    }

    private function authorizeView(Todo $todo)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) return true;

        if ($user->hasRole('supervisor')) {
            $allowedUserIds = array_merge([$user->id], $user->subordinates->pluck('id')->toArray());
            if (in_array($todo->user_id, $allowedUserIds)) return true;
        }

        if ($todo->user_id === $user->id) return true;

        abort(403, 'شما مجاز به دسترسی به این تسک نیستید.');
    }

    // public function markAsDone($id)
    // {
    //     $todo = Todo::findOrFail($id);
    //     $todo->is_done = 1;
    //     $todo->save();

    //     return redirect()->back()->with('success', 'تسک با موفقیت به عنوان انجام شده علامت‌گذاری شد.');
    // }
}