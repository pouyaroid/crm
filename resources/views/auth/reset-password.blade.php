<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ request()->route('token') }}">
    <input type="email" name="email" value="{{ old('email') }}" required>
    <input type="password" name="password" required>
    <input type="password" name="password_confirmation" required>
    <button type="submit">تغییر رمز عبور</button>
</form>
