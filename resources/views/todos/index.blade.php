@extends('layouts.app')

@section('title', 'لیست تسک‌ها')

@section('content')
    <style>
        .todo-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .todo-wrapper h2 {
            font-weight: bold;
            color: #212529;
        }

        .table th {
            white-space: nowrap;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.75em;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        @media (max-width: 576px) {
            .table,
            .table thead,
            .table tbody,
            .table th,
            .table td,
            .table tr {
                display: block;
            }

            .table thead {
                display: none;
            }

            .table tr {
                margin-bottom: 1rem;
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                overflow: hidden;
                background: #f8f9fa;
            }

            .table td {
                position: relative;
                padding-right: 50%;
                padding: 0.75rem 1rem;
                border: none;
                border-bottom: 1px solid #dee2e6;
                text-align: right;
            }

            .table td:before {
                position: absolute;
                top: 0.75rem;
                right: 1rem;
                width: 45%;
                font-weight: bold;
                color: #6c757d;
                white-space: nowrap;
                text-align: right;
                content: attr(data-label);
            }
        }
    </style>

    <div class="todo-wrapper">
        <h2 class="mb-4"><i class="bi bi-list-check me-1"></i> لیست تسک‌ها</h2>

        @if($todos->isEmpty())
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle me-2"></i> هیچ تسکی برای نمایش وجود ندارد.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-hover">
                    <thead class="table-dark text-center">
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
                                <td data-label="#"> {{ $index + 1 }} </td>
                                <td data-label="عنوان"> {{ $todo->title }} </td>
                                <td data-label="توضیحات"> {{ Str::limit($todo->description, 100) }} </td>
                                <td data-label="وضعیت">
                                    @if($todo->is_done)
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> انجام شده</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> در حال انجام</span>
                                    @endif
                                </td>
                                <td data-label="کاربر"> {{ $todo->user->name ?? '---' }} </td>
                                <td data-label="تاریخ ایجاد"> {{ jdate($todo->created_at)->format('Y/m/d H:i') }} </td>
                                <td data-label="عملیات">
                                    @php
                                        $user = auth()->user();
                                        $canEdit = $user->hasRole('admin') ||
                                                   ($user->hasRole('supervisor') && $user->subordinates->pluck('id')->contains($todo->user_id)) ||
                                                   ($todo->user_id === $user->id);
                                    @endphp

                                    @if($canEdit)
                                        <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-outline-primary btn-edit">
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
