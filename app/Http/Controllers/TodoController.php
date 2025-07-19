<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // لیست تسک‌ها
    public function index()
    {
        $user = auth()->user();
        $todos = collect();
        $users = collect();

        if ($user->hasRole('admin')) {
            // ادمین همه تسک‌ها و کاربران را می‌بیند
            $todos = Todo::with('user')->latest()->get();
            $users = User::with('todos')->get();
        } elseif ($user->hasRole('supervisor')) {
            // سرپرست تسک‌های خودش و زیرمجموعه‌ها
            $subordinateIds = $user->subordinates->pluck('id')->toArray();
            $allowedUserIds = array_merge([$user->id], $subordinateIds);

            $todos = Todo::whereIn('user_id', $allowedUserIds)->with('user')->latest()->get();
            $users = User::whereIn('id', $allowedUserIds)->with('todos')->get();
        } else {
            // کاربر عادی فقط تسک خودش
            $todos = Todo::where('user_id', $user->id)->with('user')->latest()->get();
            $users = collect();
        }

        return view('todos.index', compact('todos', 'users'));
    }

    // نمایش فرم ایجاد تسک
    public function create()
    {
        $user = auth()->user();
        $users = collect();

        if ($user->hasRole('admin')) {
            // ادمین می‌تواند برای هر کاربری تسک بسازد
            $users = User::all();
        } elseif ($user->hasRole('supervisor')) {
            // سرپرست می‌تواند برای خودش و زیرمجموعه‌ها تسک بسازد
            $subordinateIds = $user->subordinates->pluck('id')->toArray();
            $allowedUserIds = array_merge([$user->id], $subordinateIds);
            $users = User::whereIn('id', $allowedUserIds)->get();
        }
        // کاربر عادی فقط خودش هست و نیازی به ارسال لیست نیست

        return view('todos.create', compact('users'));
    }

    // ذخیره‌سازی تسک
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date',
        // 'user_id' => 'required|exists:users,id', // حذف کن
    ]);

    $currentUser = Auth::user();

    // نقش سرپرست و عادی میتونن تسک برای خودشون بسازن
    // ادمین هم میتونه هر کسی رو انتخاب کنه، پس اگر ادمین بود، user_id رو از ورودی میگیریم، در غیر اینصورت از خودش

    if ($currentUser->hasRole('admin')) {
        // برای ادمین از ورودی user_id استفاده کن
        $userId = $request->input('user_id');
        if (!$userId || !User::find($userId)) {
            return back()->withErrors(['user_id' => 'لطفا کاربر را انتخاب کنید.'])->withInput();
        }
    } else {
        // برای سرپرست و کاربر عادی، user_id خودشون ثبت میشه
        $userId = $currentUser->id;
    }

    Todo::create([
        'title' => $request->title,
        'description' => $request->description,
        'due_date' => $request->due_date,
        'user_id' => $userId,
    ]);

    return redirect()->route('todos.index')->with('success', 'تسک با موفقیت ایجاد شد.');
}

    // نمایش تسک خاص
    public function show(Todo $todo)
    {
        $this->authorizeView($todo);
        return view('todos.show', compact('todo'));
    }

    // فرم ویرایش
    public function edit(Todo $todo)
    {
        $this->authorizeView($todo);
        return view('todos.edit', compact('todo'));
    }

    // بروزرسانی
    public function update(Request $request, Todo $todo)
    {
        $this->authorizeView($todo);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'is_done' => 'nullable|boolean',
        ]);

        $todo->update($request->only('title', 'description', 'due_date', 'is_done'));

        return redirect()->route('todos.index')->with('success', 'تسک بروزرسانی شد.');
    }

    // حذف تسک
    public function destroy(Todo $todo)
    {
        $this->authorizeView($todo);
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'تسک حذف شد.');
    }

    // مجوز مشاهده یا ویرایش
    private function authorizeView(Todo $todo)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('supervisor')) {
            $allowedUserIds = array_merge([$user->id], $user->subordinates->pluck('id')->toArray());
            if (in_array($todo->user_id, $allowedUserIds)) {
                return true;
            }
        }

        if ($todo->user_id === $user->id) {
            return true;
        }

        abort(403, 'شما مجاز به دسترسی به این تسک نیستید.');
    }

    // مشاهده تسک‌های کاربر خاص (فقط برای ادمین)
    public function userTodos(User $user)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'شما دسترسی ندارید.');
        }

        $todos = $user->todos()->latest()->paginate(10);
        return view('todos.user_todos', compact('user', 'todos'));
    }
}
