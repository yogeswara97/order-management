@props(['image', 'title', 'description'])

<div {{ $attributes->merge(['class' => 'bg-white p-6 rounded-xl shadow border border-gray-200 hover:shadow-md transition']) }}>
    <div class="flex items-start gap-4">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-14 h-14 object-contain">
        <div>
            <h3 class="text-base font-semibold text-gray-800 mb-1">{{ $title }}</h3>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $description }}</p>
        </div>
    </div>
</div>
