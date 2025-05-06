@props([
    'icon',
    'title',
    'value',
    'percentage' => null,
    'percentageStatus' => null
])

@php
    $class = '';
    $iconStatus = '';

    if ($percentageStatus === 'up') {
        $class = 'bg-green-100 text-green-600';
        $iconStatus = 'fas fa-arrow-up';
    } elseif ($percentageStatus === 'down') {
        $class = 'bg-red-100 text-red-600';
        $iconStatus = 'fas fa-arrow-down';
    } elseif ($percentageStatus === 'flat') {
        $class = 'bg-gray-100 text-gray-600';
        $iconStatus = 'fas fa-arrows-h';
    }
@endphp

<div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 md:p-6">
    <div class="flex h-10 w-10 sm:h-11 sm:w-11 md:h-12 md:w-12 items-center justify-center rounded-full bg-blue-100">
        <i class="{{ $icon }} text-blue-500 text-base sm:text-lg md:text-xl"></i>
    </div>

    <div class="mt-4 sm:mt-5 md:mt-6 flex flex-col items-start justify-between">
        <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
            <span class="text-sm sm:text-base md:text-lg font-semibold text-gray-600">{{ $title }}</span>

            @if ($percentage !== null)
                <span class="flex items-center gap-1 rounded-full py-0.5 pl-2 pr-3 text-xs sm:text-sm font-medium {{ $class }}">
                    <i class="{{ $iconStatus }}"></i>
                    {{ $percentage }}%
                </span>
            @endif
        </div>

        <h4 class="mt-1.5 sm:mt-2 text-base sm:text-lg md:text-xl font-bold text-gray-800">{{ $value }}</h4>
    </div>
</div>

