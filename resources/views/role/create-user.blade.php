@extends('layouts.app')
@section('title', 'ساخت کاربر جدید')
@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ساخت کاربر جدید</title>

    <!-- Bootstrap 5 RTL CSS از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <!-- فونت فارسی Vazir از Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Vazir', sans-serif;
            background-color: #f7f8fb;
            color: #333;
        }

        .form-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            transition: transform 0.3s ease-in-out;
        }

        .form-container:hover {
            transform: translateY(-10px);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 12px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-check-label {
            font-size: 16px;
            margin-left: 10px;
            color: #495057;
        }

        .invalid-feedback {
            font-size: 0.875em;
            color: #dc3545;
        }

        .form-check {
            margin-bottom: 15px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
        }

        /* نقش‌ها با دکمه‌های زیبا */
        .role-card {
            display: inline-block;
            margin: 10px;
            padding: 15px;
            background-color: #f1f3f5;
            border-radius: 10px;
            width: 100%;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .role-card:hover {
            background-color: #007bff;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
            transform: scale(1.05);
        }

        .role-card input {
            display: none;
        }

        .role-card input:checked + label {
            background-color: #007bff;
            color: white;
        }

        .role-card input:checked + label i {
            color: white;
        }

        .role-card label {
            display: block;
            font-size: 18px;
            font-weight: 600;
            color: #495057;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }

        .role-card label i {
            margin-left: 10px;
        }

    </style>

    <div class="container">
        <div class="form-container">
            <h1 class="text-center mb-4">ساخت کاربر جدید با نقش</h1>

            <form action="{{ route('users.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">نام:</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">ایمیل:</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">رمز عبور:</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">نقش‌ها:</label><br>
                    <div class="d-flex flex-wrap justify-content-center">
                        @foreach($roles as $role)
                            <div class="role-card">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}" class="role-input">
                                <label for="role_{{ $role->id }}">
                                    <i class="bi bi-shield-lock"></i> {{ $role->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('roles')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-submit">ایجاد کاربر</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection
