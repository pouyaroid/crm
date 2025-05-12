<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست مشتریان</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            background-color: #f0f2f5;
        }
        .container {
            max-width: 95%;
            margin: 40px auto;
        }
        h2 {
            text-align: center;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 30px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
        .search-input {
            border-radius: 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 500;
        }
        table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            vertical-align: middle;
        }
        td {
            text-align: center;
            vertical-align: middle;
        }
        .table td, .table th {
            padding: 0.75rem;
            font-size: 0.95rem;
        }
        .btn-group .btn {
            margin-left: 4px;
        }
        .btn-group .btn:last-child {
            margin-left: 0;
        }
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
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
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="container">
            <strong>کاربر:</strong> {{ auth()->user()->name }} |
            <strong>نقش:</strong> {{ implode(', ', auth()->user()->getRoleNames()->toArray()) }}
        </div>
      
        <a href="{{ route('customers.select') }}" class="btn btn-success shadow">ارسال پیام گروهی</a>
    </div>

    <h2>لیست مشتریان</h2>

    <form method="GET" id="search-form" class="mb-4 border rounded p-3 bg-white shadow-sm">
        <div class="row g-2 align-items-end justify-content-center">
            <div class="col-md-6 col-lg-4">
                <label for="search" class="form-label">جستجو (نام، شرکت، ایمیل، شماره)</label>
                <input type="text" name="search" id="search" class="form-control search-input" placeholder="عبارت مورد نظر را وارد کنید">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary px-4">جستجو</button>
            </div>
        </div>
    </form>

    <div id="customer-table" class="table-responsive shadow-sm rounded-3">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    @if(auth()->user()->hasRole('admin'))
                        <th><input type="checkbox" id="select-all"></th>
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
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        @if(auth()->user()->hasRole('admin'))
                            <td><input type="checkbox" name="selected_customers[]" value="{{ $customer->id }}"></td>
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
                                <div class="btn-group">
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">ویرایش</a>
                                    <a href="{{ route('customers.message.single', $customer->id) }}" class="btn btn-info btn-sm">ارسال پیام</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $customers->links() }}
                </div>
            </tbody>
        </table>

        @if($customers->isEmpty())
            <div class="alert alert-info text-center">هیچ مشتری یافت نشد.</div>
        @endif
    </div>
</div>

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

</body>
</html>
