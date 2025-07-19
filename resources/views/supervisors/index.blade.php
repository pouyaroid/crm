@extends('layouts.app')

@section('title', 'مدیریت سرپرستان')

@section('content')
<div class="container mt-5 text-end">
    <h4>تعیین سرپرست کاربران</h4>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('supervisors.store') }}" method="POST" class="row g-3 mt-4">
        @csrf
        <div class="col-md-5">
            <label for="user_id" class="form-label">کاربر</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-5">
            <label for="supervisor_id" class="form-label">سرپرست</label>
            <select name="supervisor_id" id="supervisor_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 d-grid align-items-end">
            <button type="submit" class="btn btn-primary">ثبت</button>
        </div>
    </form>
</div>
@endsection
