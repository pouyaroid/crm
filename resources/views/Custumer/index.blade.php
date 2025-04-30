<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لیست مشتریان</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap RTL + Font --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            background: #f7f7f7;
        }
        th, td {
            vertical-align: middle;
        }
        .container {
            max-width: 1200px;
            margin-top: 20px;
        }
        h2 {
            text-align: center;
            color: #343a40;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .search-bar {
            margin-bottom: 30px;
        }
        .search-input {
            max-width: 400px;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card {
            transition: all 0.3s ease;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>

<div class="container">

    <h2 class="mb-4 fw-bold text-primary">لیست مشتریان</h2>

    {{-- فرم جستجو --}}
    <form method="GET" id="search-form" class="mb-4 border rounded p-3 bg-white shadow-sm">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label">جستجو (نام، شرکت، ایمیل، شماره)</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="عبارت مورد نظر را وارد کنید">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">جستجو</button>
            </div>
        </div>
    </form>

    {{-- جدول مشتریان --}}
    <div id="customer-table">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
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
                   
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
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
                        <td>
                            {{-- <div class="btn-group">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">ویرایش</a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                                </form>
                            </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- در صورتی که مشتری وجود نداشته باشد --}}
        @if($customers->isEmpty())
            <div class="alert alert-info text-center mt-4">هیچ مشتری یافت نشد.</div>
        @endif
    </div>

</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- AJAX برای جستجو --}}
<script>
    $(document).ready(function () {
        $('#search-form').on('submit', function (e) {
            e.preventDefault(); // جلوگیری از رفرش صفحه

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
    });
</script>

</body>
</html>
