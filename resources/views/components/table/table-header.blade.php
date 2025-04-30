<div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">

    {{-- SEARCH --}}
    <div class="w-full md:w-1/4">
        <form class="flex items-center">
            <x-search :dataset="$dataset"></x-search>
            <button type="submit" class="button-submit ml-4">
                Filter
            </button>
        </form>
    </div>

    {{-- BUTTON --}}
    <div
        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
        <a href="{{ route('customer.index') }}" class="button-delete">
            Reset Filter
        </a>
        <a href="{{ route('customer.create') }}" class="button-add">
            {{ $create }}
        </a>
    </div>
</div>

