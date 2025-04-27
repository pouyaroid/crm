<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ساخت کاربر جدید</title>
</head>
<body>
    <h1>ساخت کاربر جدید با رول</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div>
            <label>نام:</label>
            <input type="text" name="name" required>
        </div>

        <div>
            <label>ایمیل:</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>رمز عبور:</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>نقش:</label>
            <select name="role" required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">ایجاد کاربر</button>
    </form>
</body>
</html>
