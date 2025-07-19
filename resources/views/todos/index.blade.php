
@extends('layouts.app')

@section('title', 'لیست تسک‌ها')

@section('content')
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            color: #343a40;
        }

        .table {
            --bs-table-bg: #fff;
            --bs-table-striped-bg: #e9ecef;
            --bs-table-hover-bg: #f1f3f5;
        }

        .table thead th {
            background-color: #343a40;
            color: #fff;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .btn-primary {
            --bs-btn-bg: #007bff;
            --bs-btn-border-color: #007bff;
            --bs-btn-hover-bg: #0056b3;
            --bs-btn-hover-border-color: #0056b3;
        }

        .badge {
            font-size: 0.875rem;
        }

        /* Make table scroll responsive for small screens */
        @media (max-width: 991.98px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table thead th,
            .table tbody td {
                white-space: nowrap;
            }
        }

        /* Card-style table view for extra small screens */
        @media (max-width: 576px) {
            .table,
            .table thead,
            .table tbody,
            .table tr,
            .table th,
            .table td {
                display: block !important;
            }

            .table thead {
                display: none !important;
            }

            .table tr {
                margin-bottom: 1rem;
                border-bottom: 2px solid #dee2e6;
            }

            .table td {
                padding-right: 50%;
                position: relative;
                min-height: 36px;
                border: none;
                border-bottom: 1px solid #e9ecef;
                text-align: right;
            }

            .table td:before {
                position: absolute;
                top: 50%;
                right: 1rem;
                width: 45%;
                padding-left: 15px;
                transform: translateY(-50%);
                font-weight: bold;
                color: #495057;
                white-space: nowrap;
                text-align: right;
                direction: rtl;
            }

            .table td:nth-of-type(1):before { content: '#'; }
            .table td:nth-of-type(2):before { content: 'عنوان'; }
            .table td:nth-of-type(3):before { content: 'توضیحات'; }
            .table td:nth-of-type(4):before { content: 'وضعیت'; }
            .table td:nth-of-type(5):before { content: 'کاربر'; }
            .table td:nth-of-type(6):before { content: 'تاریخ ایجاد'; }
            .table td:nth-of-type(7):before { content: 'عملیات'; }
        }

        /* Reduce container padding on extra small devices */
        @media (max-width: 576px) {
            .container {
                padding: 0 2px !important;
            }
        }
    </style>

    <div class="container mt-4">
        <h2 class="mb-4">لیست تسک‌ها</h2>

        @if($todos->isEmpty())
            <div class="alert alert-info">
                هیچ تسکی برای نمایش وجود ندارد.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>توضیحات</th>
                            <th>وضعیت</th>
                            <th>کاربر</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todos as $index => $todo)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $todo->title }}</td>
                                <td>{{ $todo->description }}</td>
                                <td>
                                    @if($todo->is_done)
                                        <span class="badge bg-success">انجام شده</span>
                                    @else
                                        <span class="badge bg-warning text-dark">در حال انجام</span>
                                    @endif
                                </td>
                                <td>{{ $todo->user->name ?? '---' }}</td>
                                <td>{{ jdate($todo->created_at)->format('Y/m/d H:i') }}</td>
                                <td>
                                    @php
                                        $user = auth()->user();
                                        $canEdit = false;
                                        if ($user->hasRole('admin')) {
                                            $canEdit = true;
                                        } elseif ($user->hasRole('supervisor') && $user->subordinates->pluck('id')->contains($todo->user_id)) {
                                            $canEdit = true;
                                        } elseif ($todo->user_id === $user->id) {
                                            $canEdit = true;
                                        }
                                    @endphp

                                    @if($canEdit)
                                        <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-square"></i> ویرایش
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
