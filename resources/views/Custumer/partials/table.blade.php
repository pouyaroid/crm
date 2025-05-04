<p>نقش کاربر: {{ auth()->user()->role }}</p>

@if($customers->count())
    <div class="table-responsive">
        <table class="table table-bordered table-striped bg-white">
            <thead class="table-light">
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
                    @if(auth()->user()->hasAnyRole(['admin', 'sales_manager']))
                    <th>عملیات</th>
                @endif
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
                        @if(auth()->user()->hasAnyRole(['admin', 'sales_manager']))
                            <td>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">ویرایش</a>

                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید حذف کنید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {!! $customers->links() !!}
    </div>
@else
    <div class="alert alert-warning text-center">
        مشتری‌ای پیدا نشد.
    </div>
@endif
