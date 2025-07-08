<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class TodoController extends Controller
{
    // نمایش لیست کارها
    public function index()
    {
        $user = auth()->user();
    
        if ($user->hasRole('admin')) {
            // دریافت همه کاربران کارمند به همراه تسک‌هاشون
            $users = \App\Models\User::role('employee')->with('todos')->get();
            return view('todos.index', compact('users'));
        } else {
            // نمایش تسک‌های خودش
            $todos = $user->todos()->latest()->paginate(10);
            return view('todos.user_todos', [
                'user' => $user,
                'todos' => $todos
            ]);
        }}

    // فرم ساخت تسک جدید
    public function create()
    {
        return view('todos.create');
    }

    // ذخیره‌سازی تسک جدید
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->due_date = $request->due_date;
        $todo->user_id = Auth::id();
        $todo->save();

        return redirect()->route('todos.index')->with('success', 'تسک با موفقیت ایجاد شد.');
    }

    // نمایش یک تسک خاص
    public function show(Todo $todo)
    {
        $this->authorizeView($todo);

        return view('todos.show', compact('todo'));
    }

    // فرم ویرایش تسک
    public function edit(Todo $todo)
    {
        $this->authorizeView($todo);

        return view('todos.edit', compact('todo'));
    }

    // بروزرسانی تسک
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

    // متد خصوصی برای بررسی مجوز مشاهده/ویرایش/حذف
    private function authorizeView(Todo $todo)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return true;
        }

        if ($todo->user_id !== $user->id) {
            abort(403, 'شما اجازه دسترسی به این تسک را ندارید.');
        }
    }

    public function userTodos(User $user)
    {
        // فقط ادمین می‌تونه تسک‌های دیگران رو ببینه
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'شما دسترسی ندارید.');
        }
    
        // دریافت تسک‌های مربوط به کاربر مشخص
        $todos = $user->todos()->latest()->paginate(10);
    
        // نمایش ویو لیست تسک‌های این کاربر
        return view('todos.user_todos', compact('user', 'todos'));
    }
}
