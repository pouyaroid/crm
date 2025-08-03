@extends('layouts.app')

@section('title', 'لیست مشتریان احتمالی')

@section('content')
    <div class='container-fluid mt-4'>
        <h3 class='mb-3'>لیست مشتریان احتمالی</h3>

        @if (session('error'))
            <div class='alert alert-danger'>
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class='alert alert-success'>
                {{ session('success') }}
            </div>
        @endif

        {{-- کدهای جدید برای Export و Import --}}
        <div class="mb-3 d-flex flex-column flex-md-row gap-2">
            <a href='{{ route('leads.create') }}' class='btn btn-success w-100 d-md-inline-block d-block'>+ افزودن مشتری احتمالی</a>
            <a href='{{ route('leads.export') }}' class='btn btn-info w-100 d-md-inline-block d-block'>خروجی CSV</a>
            <a href='{{ route('leads.import.form') }}' class='btn btn-secondary w-100 d-md-inline-block d-block'>ایمپورت فایل</a>
        </div>

        <form action='{{ route('leads.index') }}' method='GET' class='row g-2 mb-3'>
            <div class='col-md-2 col-12'>
                <input type='text' name='search' class='form-control' placeholder='نام یا تلفن' value='{{ request('search') }}'>
            </div>
            <div class='col-md-2 col-12'>
                <input type='text' name='company' class='form-control' placeholder='شرکت' value='{{ request('company') }}'>
            </div>
            <div class='col-md-2 col-12'>
                <input type='text' name='source' class='form-control' placeholder='منبع' value='{{ request('source') }}'>
            </div>
            <div class='col-md-2 col-12'>
                <select name='interest_level' class='form-select'>
                    <option value=''>سطح علاقه</option>
                    <option value='کم' {{ request('interest_level') == 'کم' ? 'selected' : '' }}>کم</option>
                    <option value='متوسط' {{ request('interest_level') == 'متوسط' ? 'selected' : '' }}>متوسط</option>
                    <option value='زیاد' {{ request('interest_level') == 'زیاد' ? 'selected' : '' }}>زیاد</option>
                </select>
            </div>
            <div class='col-md-2 col-12'>
                <select name='status' class='form-select'>
                    <option value=''>وضعیت</option>
                    <option value='در انتظار تماس' {{ request('status') == 'در انتظار تماس' ? 'selected' : '' }}>در انتظار تماس</option>
                    <option value='تماس گرفته شد' {{ request('status') == 'تماس گرفته شد' ? 'selected' : '' }}>تماس گرفته شد</option>
                    <option value='تبدیل به مشتری شد' {{ request('status') == 'تبدیل به مشتری شد' ? 'selected' : '' }}>تبدیل به مشتری شد</option>
                </select>
            </div>
            <div class='col-md-auto col-12'>
                <button type='submit' class='btn btn-outline-primary w-100'>جستجو</button>
            </div>
        </form>

        <div class='d-none d-lg-block table-responsive'>
            <table class='table table-bordered align-middle'>
                <thead class='table-light text-center'>
                    <tr>
                        <th>نام</th>
                        <th>تلفن</th>
                        <th>شرکت</th>
                        <th>منبع</th>
                        <th>سطح علاقه</th>
                        <th>وضعیت</th>
                        <th>یادداشت</th>
                        <th>ثبت‌کننده</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->company }}</td>
                        <td>{{ $lead->source }}</td>
                        <td>{{ $lead->interest_level }}</td>
                        <td>{{ $lead->status }}</td>
                        <td>{{ $lead->note }}</td>
                        <td>{{ $lead->user->name ?? 'سیستم' }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <a href='{{ route('leads.calls.create', $lead->id) }}' class='btn btn-sm btn-primary'>افزودن تماس</a>
                                <a href='{{ route('leads.show', $lead->id) }}' class='btn btn-sm btn-secondary'>مشاهده تماس‌ها</a>
                                <a href='{{ route('leads.edit', $lead->id) }}' class='btn btn-sm btn-warning'>ویرایش</a>
                                <form action='{{ route('leads.convert', $lead->id) }}' method='POST' class='d-inline'>
                                    @csrf
                                    <button type='submit' class='btn btn-sm btn-success'>تبدیل به مشتری</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-lg-none">
            @foreach($leads as $lead)
            <div class="card mb-2 shadow-sm">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">{{$lead->name}}</h6>
                            <div style="font-size: 13px;">
                                <div><strong>تلفن:</strong> {{$lead->phone}}</div>
                                <div><strong>شرکت:</strong> {{$lead->company}}</div>
                                <div><strong>منبع:</strong> {{$lead->source}}</div>
                                <div><strong>سطح علاقه:</strong> {{$lead->interest_level}}</div>
                                <div><strong>وضعیت:</strong> {{$lead->status}}</div>
                                <div><strong>یادداشت:</strong> {{$lead->note}}</div>
                                <div><strong>ثبت‌کننده:</strong> {{$lead->user->name ?? 'سیستم'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex flex-wrap gap-1">
                        <a href='{{ route('leads.calls.create', $lead->id) }}' class='btn btn-sm btn-primary'>افزودن تماس</a>
                        <a href='{{ route('leads.show', $lead->id) }}' class='btn btn-sm btn-secondary'>مشاهده تماس‌ها</a>
                        <a href='{{ route('leads.edit', $lead->id) }}' class='btn btn-sm btn-warning'>ویرایش</a>
                        <form action='{{ route('leads.convert', $lead->id) }}' method='POST' class='d-inline'>
                            @csrf
                            <button type='submit' class='btn btn-sm btn-success'>تبدیل به مشتری</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class='d-flex justify-content-center mt-3'>
            {{ $leads->links() }}
        </div>
    </div>
    <style>
        @media (max-width: 767.98px) {
            .card h6 { font-size: 16px; }
            .card strong { min-width: 80px; display: inline-block; }
        }
        @media (max-width: 450px) {
            .card .btn, .card .btn-sm { font-size: 12px!important; padding: 0.3rem 0.7rem!important;}
        }
    </style>
@endsection