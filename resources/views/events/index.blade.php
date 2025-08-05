@extends('layouts.app')

@section('title', 'تقویم رویدادها' )

@section('content')
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تقویم رویدادها</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- فونت وزیر -->
  <style>
    @import url('https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.3/Vazirmatn-font-face.css');
    body {
      font-family: 'Vazirmatn', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen antialiased text-gray-800">
  <div class="max-w-7xl mx-auto py-12 px-4">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-center text-indigo-700 mb-12">
      تقویم رویدادها
    </h1>

    @if ($events->isEmpty())
      <div class="bg-white border border-gray-200 rounded-xl shadow p-10 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-400 mb-4" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 011-1h2a1 1 0 110 2h-2v2a1 1 0 11-2 0V9a1 1 0 011-1zm1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
        </svg>
        <p class="text-xl font-semibold text-gray-600">هیچ رویدادی پیدا نشد.</p>
        <p class="mt-2 text-gray-500">در حال حاضر هیچ رویدادی در تقویم وجود ندارد.</p>
      </div>
    @else
      @php
        $sortedEvents = $events->sortBy(function ($event) {
          return \Carbon\Carbon::createFromFormat('Y/m/d', $event->event_date_jalali)->timestamp;
        })->values();
      @endphp

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($sortedEvents as $event)
          <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden flex flex-col justify-between">
            <!-- تقویم بالا -->
            <div class="bg-indigo-600 text-white text-center py-4 px-2">
              <div class="text-2xl font-bold">
                {{ \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $event->event_date_jalali)->format('%d') }}
              </div>
              <div class="text-sm">
                {{ \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $event->event_date_jalali)->format('%B') }}
              </div>
              <div class="text-xs mt-1">
                {{ \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $event->event_date_jalali)->format('%Y') }}
              </div>
              @if ($event->end_date_jalali !== 'ندارد')
                <div class="text-xs mt-1">تا {{ $event->end_date_jalali }}</div>
              @endif
            </div>

            <!-- محتوای رویداد -->
            <div class="p-5 flex flex-col h-full justify-between">
              <div>
                <h2 class="text-lg font-bold text-gray-800 mb-2 hover:text-indigo-600 transition duration-300">
                  {{ $event->title }}
                </h2>
                <p class="text-gray-600 text-sm mb-3 leading-relaxed">
                  {{ Str::limit($event->description, 100) }}
                </p>

                <div class="flex items-center text-gray-500 text-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                  </svg>
                  {{ $event->location }}
                </div>
              </div>

              <!-- دکمه حذف -->
              @if(auth()->user()->id === $event->user_id || auth()->user()->hasRole('admin'))
                <div class="mt-6">
                  <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این رویداد مطمئن هستید؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-600 text-sm font-semibold rounded-lg transition duration-200">
                      حذف رویداد
                    </button>
                  </form>
                </div>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</body>
</html>
@endsection
