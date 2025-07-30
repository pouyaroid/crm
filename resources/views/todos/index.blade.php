@extends('layouts.app')

@section('title', 'لیست تسک‌ها')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h3 class="mb-0"><i class="bi bi-list-check me-2"></i> لیست تسک‌ها</h3>
                <a href="{{ route('todos.create') }}" class="btn btn-light btn-sm d-flex align-items-center">
                    <i class="bi bi-plus-circle me-2"></i> افزودن تسک جدید
                </a>
            </div>
            <div class="card-body p-4">
                @if($todos->isEmpty())
                    <div class="alert alert-info d-flex align-items-center justify-content-center py-4" role="alert">
                        <i class="bi bi-info-circle me-2 fa-lg"></i>
                        <h4 class="mb-0">هیچ تسکی برای نمایش وجود ندارد.</h4>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle text-center">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">عنوان</th>
                                    <th scope="col">توضیحات</th>
                                    <th scope="col">وضعیت</th>
                                    <th scope="col">کاربر</th>
                                    <th scope="col">تاریخ ایجاد</th>
                                    <th scope="col">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todos as $index => $todo)
                                    <tr class="{{ $todo->is_done ? 'table-success' : '' }}">
                                        <td data-label="#">{{ $index + 1 }}</td>
                                        <td data-label="عنوان">{{ $todo->title }}</td>
                                        <td data-label="توضیحات">
                                            <span class="d-inline-block text-truncate" style="max-width: 250px;">
                                                {{ Str::limit($todo->description, 100, '...') }}
                                            </span>
                                        </td>
                                        <td data-label="وضعیت">
                                            @if($todo->is_done)
                                                <span class="badge bg-success-light text-success px-3 py-2 rounded-pill">
                                                    <i class="bi bi-check-circle-fill me-1"></i> انجام شده
                                                </span>
                                            @else
                                                <span class="badge bg-warning-light text-warning px-3 py-2 rounded-pill">
                                                    <i class="bi bi-hourglass-split me-1"></i> در حال انجام
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="کاربر">{{ $todo->user->name ?? '---' }}</td>
                                        <td data-label="تاریخ ایجاد">{{ jdate($todo->created_at)->format('Y/m/d H:i') }}</td>
                                        <td data-label="عملیات">
                                            @php
                                                $user = auth()->user();
                                                $canEdit = $user->hasRole('admin') ||
                                                            ($user->hasRole('supervisor') && $user->subordinates->pluck('id')->contains($todo->user_id)) ||
                                                            ($todo->user_id === $user->id);
                                            @endphp

                                            @if($canEdit)
                                                <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="ویرایش تسک">
                                                    <i class="bi bi-pencil me-1"></i> ویرایش
                                                </a>
                                                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" data-bs-toggle="tooltip" data-bs-placement="top" title="حذف تسک">
                                                        <i class="bi bi-trash me-1"></i> حذف
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">بدون دسترسی</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .container {
        max-width: 1400px; /* Slightly increase max-width for content to feel less constrained */
        margin-right: auto; /* Ensure centering for RTL if it's a fixed width */
        margin-left: auto;
    }

    .card {
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        border-bottom: none;
        padding: 1.5rem 2rem;
        border-top-left-radius: 1.25rem;
        border-top-right-radius: 1.25rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); /* Gradient header */
    }

    .card-header h3 {
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .btn-light {
        color: #667eea;
        background-color: #ffffff;
        border-color: #ffffff;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        color: #764ba2;
        background-color: #f0f2f5;
        border-color: #f0f2f5;
    }

    .table thead th {
        background-color: #e9ecef; /* Lighter header for table */
        color: #495057;
        font-weight: 700;
        border-bottom: 2px solid #dee2e6;
        padding: 1rem;
    }

    .table tbody tr {
        transition: all 0.2s ease-in-out;
        background-color: #ffffff;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .table tbody tr.table-success {
        background-color: #d4edda !important; /* Lighter success background */
    }

    .badge {
        font-weight: 600;
        letter-spacing: 0.2px;
        font-size: 0.8em;
    }

    .bg-success-light {
        background-color: #e6ffed !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .bg-warning-light {
        background-color: #fff3cd !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .btn-outline-primary {
        border-color: #667eea;
        color: #667eea;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #667eea;
        color: #fff;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .alert {
        border-radius: 0.75rem;
        font-size: 1.1rem;
        font-weight: 500;
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }

    /* --- Responsive Table Styling (Using CSS Grid for TD elements) --- */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 992px) {
        .table thead {
            display: none; /* Hide table header on smaller screens */
        }

        .table, .table tbody, .table tr {
            display: block;
            width: 100%;
        }

        .table tr {
            margin-bottom: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            overflow: hidden; /* Ensure content stays within the rounded corners */
        }

        .table td {
            display: grid; /* Use CSS Grid for each table cell */
            grid-template-columns: 40% 1fr; /* 40% for label, remaining for content */
            gap: 0.5rem; /* Small gap between label and content */
            padding: 0.75rem 1.25rem;
            border: none;
            border-bottom: 1px solid #eee;
            text-align: right; /* Default text alignment for the whole cell */
            align-items: center; /* Vertically align items in the grid */
            word-break: break-word; /* Ensure text breaks within its column */
            white-space: normal; /* Allow text wrapping */
        }

        .table td:last-child {
            /* For the "عملیات" (actions) column */
            display: flex; /* Back to flex for button alignment */
            flex-wrap: wrap;
            justify-content: flex-end; /* Align actions to the right */
            gap: 0.5rem;
            border-bottom: none; /* No border for the last cell */
            padding-right: 1.25rem; /* Reset padding for buttons */
        }

        /* The ::before pseudo-element now becomes the first grid item */
        .table td:before {
            content: attr(data-label);
            display: inline-block; /* Make it behave like a block in grid */
            font-weight: 700;
            color: #6c757d;
            text-align: left; /* Align the label text to the left within its 40% column */
            white-space: normal; /* Allow the label itself to wrap if too long */
            padding-left: 0.5rem; /* Small padding if needed for visual separation */
        }

        /* Adjustments for specific content within cells */
        .table td:nth-child(2) { /* "عنوان" column */
            /* No specific changes needed with grid, as word-break handles it */
        }
        .table td:nth-child(3) { /* "توضیحات" column */
            /* If Str::limit causes issues with truncate span, remove max-width here if needed */
        }

        /* Special handling for the # column which only has a number */
        .table td:first-child {
            text-align: center; /* Center the number itself */
            justify-content: center; /* Center content horizontally in grid */
            grid-template-columns: 1fr; /* Make it a single column for centering */
        }
        .table td:first-child:before {
            display: none; /* Hide the label for the '#' column */
        }
    }

    @media (max-width: 576px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .card-header .btn {
            margin-top: 1rem;
            width: 100%;
        }

        /* Further adjustments for very small screens if needed */
        .table td {
            grid-template-columns: 45% 1fr; /* Give label slightly more space on smaller phones */
        }
        .table td:before {
            width: auto; /* Let grid handle width */
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tooltips initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Confirmation for delete button
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('آیا از حذف این تسک اطمینان دارید؟ این عمل غیر قابل بازگشت است.')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush