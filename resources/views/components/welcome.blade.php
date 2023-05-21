<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
    <a href="{{ route('contacts') }}">
        <div
            class="bg-indigo-50 hover:bg-indigo-400 text-indigo-800 hover:text-indigo-100 rounded p-5 m-2 shadow flex flex-col gap-y-2 justify-center items-center">
            <h2 class="text-xl lg:text-4xl font-medium">{{ $contacts->count() }}</h2>
            <p class="text-sm uppercase">
                {{ $contacts->count() > 1 ? __('Contacts') : __('Contact') }}
            </p>
        </div>
    </a>
</div>
