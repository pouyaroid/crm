@extends('layouts.app')

@section('title', 'سابقه تماس')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">
        <span class="text-indigo-600">{{ $customer->company_name }}</span> - سابقه تماس‌ها
    </h2>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($calls->isEmpty())
        <div class="p-6 text-center text-gray-600 bg-gray-100 border rounded-lg shadow-sm">
            هیچ تماسی برای این مشتری ثبت نشده است.
        </div>
    @else
        <div class="bg-gray-50 border border-gray-200 rounded-lg shadow-sm p-4 space-y-4">
            @foreach($calls as $call)
                <div class="flex {{ $loop->index % 2 === 0 ? 'justify-start' : 'justify-end' }}">
                    <div class="max-w-md w-full bg-white rounded-xl shadow-md p-4 border border-gray-200 relative">
                        <div class="text-sm text-gray-500 mb-1 flex justify-between">
                            <span class="font-semibold text-indigo-600">{{ $call->user->name ?? '---' }}</span>
                            <span>{{ \Morilog\Jalali\Jalalian::fromDateTime($call->called_at)->format('Y/m/d H:i') }}</span>
                        </div>
                        <div class="text-gray-800 font-bold mb-2">
                            {{ $call->title ?? '---' }}
                        </div>
                        <div class="text-gray-700 whitespace-pre-line text-sm">
                            {{ $call->description ?? '---' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
