@props(['status' => session('status'), 'message' => session('message')])

<div x-data="{{ json_encode(['show' => true, 'status' => $status, 'message' => $message]) }}" x-show="show && message" x-transition x-transition.duration.500ms x-cloak
    class="flex justify-around items-center px-4 py-2 font-bold text-lg rounded shadow mb-3"
    :class="{
        'bg-teal-50 text-teal-600': status == 'success',
        'bg-red-50 text-red-600': status == 'error'
    }"
    x-init="document.addEventListener('alert-message', function(event) {
        status = event.detail.status;
        message = event.detail.message;
        show = true;
    })">
    <div class="flex justify-between w-[90%]">
        <span x-text="message"></span>
        <template x-if="status == 'error'">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        </template>
        <template x-if="status == 'success'">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </template>
    </div>
    <span class="cursor-pointer hover:opacity-80" x-on:click="show = false">&times;</span>
</div>
