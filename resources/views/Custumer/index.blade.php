
@extends('layouts.app')

@section('title', 'لیست مشتریان')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary fw-bold">لیست مشتریان</h2>
            <div class="d-flex align-items-center gap-3">
                <div class="text-muted">
                    <strong>کاربر:</strong> {{ auth()->user()->name }} | 
                    <strong>نقش:</strong> {{ implode(', ', auth()->user()->getRoleNames()->toArray()) }}
                </div>
                <a href="{{ route('customers.select') }}" class="btn btn-success shadow-sm rounded-pill px-4">
                    <i class="bi bi-envelope-fill me-2"></i>ارسال پیام گروهی
                </a>
            </div>
        </div>

        <!-- Search Form -->
        <form method="GET" id="search-form" class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6 col-lg-4">
                        <label for="search" class="form-label fw-medium text-muted">جستجو (نام، شرکت، ایمیل، شماره)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" id="search" class="form-control border-start-0 rounded-end-pill" placeholder="عبارت مورد نظر را وارد کنید">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">جستجو</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                @if(auth()->user()->hasRole('admin'))
                                    <th><input type="checkbox" id="select-all" class="form-check-input bg-white"></th>
                                @endif
                                <th>نام شخص</th>
                                <th>نام شرکت</th>
                                <th>نوع شرکت</th>
                                <th>ایمیل</th>
                                <th>آدرس</th>
                                <th>مدیرعامل</th>
                                <th>بانک</th>
                                <th>توضیحات</th>
                                <th>شماره حساب</th>
                                <th>شماره شرکت</th>
                                <th>شماره موبایل</th>
                                <th>کد ملی</th>
                                <th>کد پستی</th>
                                <th>کد اقتصادی</th>
                                @if(auth()->user()->hasRole('admin'))
                                    <th>عملیات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="customer-table">
                            @foreach($customers as $customer)
                                <tr class="animate-row">
                                    @if(auth()->user()->hasRole('admin'))
                                        <td><input type="checkbox" name="selected_customers[]" value="{{ $customer->id }}" class="form-check-input"></td>
                                    @endif
                                    <td>{{ $customer->personal_name }}</td>
                                    <td>{{ $customer->company_name }}</td>
                                    <td>{{ $customer->company_type }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->ceo }}</td>
                                    <td>{{ $customer->bank }}</td>
                                    <td>{{ $customer->note }}</td>
                                    <td>{{ $customer->account_number }}</td>
                                    <td>{{ $customer->company_phone }}</td>
                                    <td>{{ $customer->mobile_phone }}</td>
                                    <td>{{ $customer->id_meli }}</td>
                                    <td>{{ $customer->postal_code }}</td>
                                    <td>{{ $customer->code_eghtesadi }}</td>
                                    @if(auth()->user()->hasRole('admin'))
                                        <td>
                                            <div class="d-flex gap-2 flex-wrap justify-content-center">
                                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm">
                                                    <i class="bi bi-pencil me-1"></i>ویرایش
                                                </a>
                                                <a href="{{ route('customers.message.single', $customer->id) }}" class="btn btn-info btn-sm rounded-pill px-3 shadow-sm">
                                                    <i class="bi bi-envelope me-1"></i>ارسال پیام
                                                </a>
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm">
                                                        <i class="bi bi-trash me-1"></i>حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($customers->isEmpty())
            <div class="alert alert-info text-center mt-4 shadow-sm">هیچ مشتری یافت نشد.</div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <style>
        /* Custom Styles */
        .card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .form-control, .input-group-text {
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.2);
            border-color: #0d6efd;
        }
        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #0a58ca);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0a58ca, #084298);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }
        .btn-success {
            background: linear-gradient(45deg, #198754, #146c43);
        }
        .btn-success:hover {
            background: linear-gradient(45deg, #146c43, #0f5132);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.4);
        }
        .btn-warning, .btn-info, .btn-danger {
            transition: all 0.3s ease;
        }
        .btn-warning:hover, .btn-info:hover, .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .table th {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 15px;
            font-weight: 600;
        }
        .table td {
            text-align: center;
            padding: 12px;
            font-size: 0.95rem;
            transition: background-color 0.2s ease;
        }
        .table tr:hover td {
            background-color: rgba(13, 110, 253, 0.05);
        }
        .animate-row {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pagination .page-link {
            border-radius: 50%;
            margin: 0 5px;
            transition: all 0.2s ease;
        }
        .pagination .page-link:hover {
            background-color: #0d6efd;
            color: white;
            transform: scale(1.1);
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 3px 10px rgba(13, 110, 253, 0.3);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: start;
                gap: 15px;
            }
            .table-responsive {
                font-size: 0.85rem;
            }
            .table th, .table td {
                padding: 8px;
            }
            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
            .btn-group .btn {
                width: 100%;
                margin: 0 !important;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
            $('#search-form').on('submit', function (e) {
                e.preventDefault();
                let query = $('#search').val();
                $.ajax({
                    url: '{{ route("customers.ajax") }}',
                    type: 'GET',
                    data: { search: query },
                    success: function (response) {
                        $('#customer-table').html(response);
                    },
                    error: function () {
                        alert('خطا در دریافت اطلاعات');
                    }
                });
            });

            $('#select-all').on('click', function () {
                $('input[name="selected_customers[]"]').prop('checked', this.checked);
            });
        });
    </script>
@endsection
