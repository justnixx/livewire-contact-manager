<div class="py-12">
    @php
        $contacts = $foundContacts ?? $contacts; // foundContacts = search results
    @endphp
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-alert />

        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 lg:p-8">
                <div class="flex items-center justify-between py-1 border-b border-slate-100">
                    <livewire:search-contacts />
                    <x-button wire:click="openContactModal()">{{ __('New') }}</x-button>
                </div>
                <div class="min-h-[400px] mt-5 overflow-x-auto border rounded-xl border-slate-100 relative">
                    @if (!$contacts->count())
                        <div class="absolute flex flex-col items-center justify-center w-full h-full">
                            <p class="p-2 text-lg font-medium text-center text-slate-500">
                                {{ $foundContacts ? __('No matching contacts found.') : __('You have no contacts.') }}
                            </p>
                        </div>
                    @else
                        <table class="w-full text-left table-auto border-collapse min-w-[800px] text-sm">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="p-2 text-gray-800 border-b border-slate-200">{{ __('Avatar') }}</th>
                                    <th class="p-2 text-gray-800 border-b border-slate-200">{{ __('First Name') }}</th>
                                    <th class="p-2 text-gray-800 border-b border-slate-200">{{ __('Last Name') }}</th>
                                    <th class="p-2 text-gray-800 border-b border-slate-200">{{ __('Email') }}</th>
                                    <th class="p-2 text-gray-800 border-b border-slate-200">{{ __('Mobile') }}</th>
                                    <th class="p-2 text-gray-800 border-b border-slate-200">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($contacts as $contact)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-2 border-b border-slate-200">
                                            <img class="object-cover object-center h-8 rounded-full"
                                                src="{{ Storage::url('contacts/' . $contact->image) }}"
                                                alt="{{ $contact->first_name }}">
                                        </td>
                                        <td class="p-2 capitalize border-b border-slate-200">{{ $contact->first_name }}
                                        </td>
                                        <td class="p-2 capitalize border-b border-slate-200">{{ $contact->last_name }}
                                        </td>
                                        <td class="p-2 lowercase border-b border-slate-200">{{ $contact->email }}</td>
                                        <td class="p-2 lowercase border-b border-slate-200">{{ $contact->mobile }}</td>
                                        <td class="p-2 border-b border-slate-200">
                                            <div class="flex justify-end gap-x-2">
                                                <x-button
                                                    class="px-2 py-1 text-xs bg-teal-500 hover:bg-teal-400 focus:bg-teal-400"
                                                    wire:click='openContactModal(true, {{ $contact->id }})'>
                                                    {{ __('Edit') }}
                                                </x-button>
                                                <x-button
                                                    class="px-2 py-1 text-xs bg-red-500 hover:bg-red-400 focus:bg-red-400"
                                                    wire:click="openConfirmationModal({{ $contact->id }})">
                                                    {{ __('Delete') }}
                                                </x-button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <div class="p-3 lg:p-5">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
    <x-dialog-modal wire:model="showContactModal">
        <x-slot name='title'>
            <h2>{{ $editMode ? __('Edit Contact') : __('New Contact') }}</h2>
        </x-slot>
        <x-slot name='content'>
            <form method="POST">
                <div class="flex flex-wrap justify-between mt-4 gap-x-4">
                    <div class="flex-1">
                        <x-label for="first-name" class="text-xs font-bold">{{ __('First name') }}</x-label>
                        <x-input wire:model.lazy="firstName" id="first-name" type="text"
                            class="border {{ $errors->has('firstName') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('First name') }}" value="{{ $firstName }}" />
                        @error('firstName')
                            <small
                                class="inline-block w-full p-1 font-bold text-red-600 border border-t-0 border-red-600 rounded-b bg-red-50">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <x-label for="last-name" class="text-xs font-bold">{{ __('Last name') }}</x-label>
                        <x-input wire:model.lazy="lastName" id="last-name" type="text"
                            class="border {{ $errors->has('lastName') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('Last name') }}" value="{{ $lastName }}" />
                        @error('lastName')
                            <small
                                class="inline-block w-full p-1 font-bold text-red-600 border border-t-0 border-red-600 rounded-b bg-red-50">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap justify-between mt-4 gap-x-4">
                    <div class="flex-1">
                        <x-label for="mobile" class="text-xs font-bold">{{ __('Mobile') }}</x-label>
                        <x-input wire:model.lazy="mobile" id="mobile" type="tel"
                            class="border {{ $errors->has('mobile') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('Mobile') }}" value="{{ $mobile }}" />
                        @error('mobile')
                            <small
                                class="inline-block w-full p-1 font-bold text-red-600 border border-t-0 border-red-600 rounded-b bg-red-50">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <x-label for="email" class="text-xs font-bold">{{ __('Email') }}</x-label>
                        <x-input wire:model.lazy="email" id="email" type="tel"
                            class="border {{ $errors->has('email') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('Email') }}" value="{{ $email }}" />
                        @error('email')
                            <small
                                class="inline-block w-full p-1 font-bold text-red-600 border border-t-0 border-red-600 rounded-b bg-red-50">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap justify-between mt-4 gap-x-4">
                    <div class="flex-1">
                        <x-label for="avatar" class="text-xs font-bold">{{ __('Avatar') }}</x-label>
                        <div
                            class="bg-teal-200 relative border {{ $errors->has('image') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full">
                            <span
                                class="font-bold pointer-events-none">{{ $currentContact ? __('Change current avatar') : __('Upload avatar') }}</span>
                            <x-input wire:model.lazy="image" id="avatar" type="file"
                                class="absolute inset-0 z-10 w-full h-full border opacity-0 cursor-pointer pointer-events-auto" />
                        </div>
                        @error('image')
                            <small
                                class="inline-block w-full p-1 font-bold text-red-600 border border-t-0 border-red-600 rounded-b bg-red-50">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name='footer'>
            <div class="flex items-center justify-between w-full">
                @if ($image)
                    <img class="object-cover object-center h-12 rounded-full" src="{{ $image->temporaryUrl() }}"
                        alt="{{ $firstName }}">
                @elseif ($currentContact)
                    <img class="object-cover object-center h-12 rounded-full"
                        src="{{ Storage::url('contacts/' . $currentContact->image) }}"
                        alt="{{ $currentContact->first_name }}">
                @endif
                @if ($editMode)
                    <x-button class="bg-teal-500 hover:bg-teal-400 focus:bg-teal-400" wire:click="update">
                        {{ __('Update') }}</x-button>
                @else
                    <x-button class="bg-teal-500 hover:bg-teal-400 focus:bg-teal-400" wire:click="create">
                        {{ __('Create') }}</x-button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>

    <x-confirmation-modal wire:model="showConfirmationModal">
        <x-slot name="title">One sec!</x-slot>
        <x-slot name="content">
            <p class="text-lg text-gray-800">Are you sure you want to delete this contact?</p>
        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-2">
                <x-button wire:click="cancel">
                    {{ __('Cancel') }}</x-button>
                <x-button class="bg-red-500 hover:bg-red-400 focus:bg-red-400" wire:click="delete()">
                    {{ __('Yes') }}</x-button>
            </div>
        </x-slot>
    </x-confirmation-modal>
</div>
