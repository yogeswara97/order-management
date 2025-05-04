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

<div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
        <i class="{{ $icon }} text-blue-500"></i>
    </div>

    <div class="mt-6 flex flex-col items-start justify-between">
        <div class="flex items-center gap-4">
            <span class="text-lg font-semibold text-gray-600">{{ $title }}</span>

            @if ($percentage !== null)
                <span class="flex items-center gap-1 rounded-full py-1 pl-2 pr-3 text-sm font-medium {{ $class }}">
                    <i class="{{ $iconStatus }}"></i>
                    {{ $percentage }}%
                </span>
            @endif
        </div>

        <h4 class="mt-2 text-lg font-bold text-gray-800">{{ $value }}</h4>
    </div>
</div>
