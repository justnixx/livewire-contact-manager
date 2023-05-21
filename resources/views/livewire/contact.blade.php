<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <x-alert />

        <div class="bg-white shadow-xl sm:rounded-lg overflow-hidden">
            <div class="bg-white p-6 lg:p-8 border-b border-gray-200">
                <div class="flex justify-end items-center border-b border-slate-100 py-1">
                    <x-button wire:click="openContactModal()">{{ __('New') }}</x-button>
                </div>
                <div class="mt-5 overflow-x-auto rounded-xl border border-slate-100">
                    @if (!$contacts->count())
                        <p class="text-center text-lg text-slate-500 font-medium p-2">{{ __('You have no contacts.') }}
                        </p>
                    @else
                        <table class="w-full text-left table-auto border-collapse min-w-[800px] text-sm">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="p-2 border-b border-slate-200 text-gray-800">{{ __('Avatar') }}</th>
                                    <th class="p-2 border-b border-slate-200 text-gray-800">{{ __('First Name') }}</th>
                                    <th class="p-2 border-b border-slate-200 text-gray-800">{{ __('Last Name') }}</th>
                                    <th class="p-2 border-b border-slate-200 text-gray-800">{{ __('Email') }}</th>
                                    <th class="p-2 border-b border-slate-200 text-gray-800">{{ __('Mobile') }}</th>
                                    <th class="p-2 border-b border-slate-200 text-gray-800">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($contacts as $contact)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-2 border-b border-slate-200">
                                            <img class="rounded-full h-8 object-cover object-center"
                                                src="{{ Storage::url('contacts/' . $contact->image) }}"
                                                alt="{{ $contact->first_name }}">
                                        </td>
                                        <td class="p-2 border-b border-slate-200 capitalize">{{ $contact->first_name }}
                                        </td>
                                        <td class="p-2 border-b border-slate-200 capitalize">{{ $contact->last_name }}
                                        </td>
                                        <td class="p-2 border-b border-slate-200 lowercase">{{ $contact->email }}</td>
                                        <td class="p-2 border-b border-slate-200 lowercase">{{ $contact->mobile }}</td>
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
                <div class="flex flex-wrap gap-x-4 justify-between mt-4">
                    <div class="flex-1">
                        <x-label for="first-name" class="font-bold text-xs">{{ __('First name') }}</x-label>
                        <x-input wire:model.lazy="firstName" id="first-name" type="text"
                            class="border {{ $errors->has('firstName') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('First name') }}" value="{{ $firstName }}" />
                        @error('firstName')
                            <small
                                class="bg-red-50 text-red-600 font-bold p-1 w-full inline-block border border-red-600 border-t-0 rounded-b">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <x-label for="last-name" class="font-bold text-xs">{{ __('Last name') }}</x-label>
                        <x-input wire:model.lazy="lastName" id="last-name" type="text"
                            class="border {{ $errors->has('lastName') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('Last name') }}" value="{{ $lastName }}" />
                        @error('lastName')
                            <small
                                class="bg-red-50 text-red-600 font-bold p-1 w-full inline-block border border-red-600 border-t-0 rounded-b">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap gap-x-4 justify-between mt-4">
                    <div class="flex-1">
                        <x-label for="mobile" class="font-bold text-xs">{{ __('Mobile') }}</x-label>
                        <x-input wire:model.lazy="mobile" id="mobile" type="tel"
                            class="border {{ $errors->has('mobile') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('Mobile') }}" value="{{ $mobile }}" />
                        @error('mobile')
                            <small
                                class="bg-red-50 text-red-600 font-bold p-1 w-full inline-block border border-red-600 border-t-0 rounded-b">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <x-label for="email" class="font-bold text-xs">{{ __('Email') }}</x-label>
                        <x-input wire:model.lazy="email" id="email" type="tel"
                            class="border {{ $errors->has('email') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full"
                            placeholder="{{ __('Email') }}" value="{{ $email }}" />
                        @error('email')
                            <small
                                class="bg-red-50 text-red-600 font-bold p-1 w-full inline-block border border-red-600 border-t-0 rounded-b">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-wrap gap-x-4 justify-between mt-4">
                    <div class="flex-1">
                        <x-label for="avatar" class="font-bold text-xs">{{ __('Avatar') }}</x-label>
                        <div
                            class="bg-teal-200 relative border {{ $errors->has('image') ? 'border-red-600 rounded-b-none border-b-0' : 'border-slate-200' }} rounded px-4 py-2 focus:outline-none focus:ring-0 focus:border-inherit h-10 w-full">
                            <span
                                class="pointer-events-none font-bold">{{ $currentContact ? __('Change current avatar') : __('Upload avatar') }}</span>
                            <x-input wire:model.lazy="image" id="avatar" type="file"
                                class="opacity-0  cursor-pointer border pointer-events-auto z-10 absolute inset-0 h-full w-full" />
                        </div>
                        @error('image')
                            <small
                                class="bg-red-50 text-red-600 font-bold p-1 w-full inline-block border border-red-600 border-t-0 rounded-b">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name='footer'>
            <div class="flex justify-between w-full items-center">
                @if ($image)
                    <img class="rounded-full h-12 object-cover object-center" src="{{ $image->temporaryUrl() }}"
                        alt="{{ $firstName }}">
                @elseif ($currentContact)
                    <img class="rounded-full h-12 object-cover object-center"
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
