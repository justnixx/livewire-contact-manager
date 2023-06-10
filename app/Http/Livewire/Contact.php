<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Contact as ContactModel;
use Illuminate\Support\Facades\Storage;

class Contact extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $listeners = ['searchUpdated' => 'getSearchResults'];

    public  $showContactModal      = false;
    public  $showConfirmationModal = false;
    public  $editMode              = false;
    public  $currentContact        = null;
    private $validationRules       = [
        'firstName' => 'required|string|min:2',
        'lastName'  => 'required|string|min:2',
        'email'     => 'email|unique:contacts,email',
        'mobile'    => 'required|string|unique:contacts,mobile',
        'image'     => 'image|max:1024',                           // 1MB Max
    ];
    protected $foundContacts; // search results

    public function mount()
    {
        $this->getSearchResults(request()->query('f', ''));
    }

    // Contact fields
    public $image, $firstName, $lastName, $mobile, $email;

    // Creates new contact
    public function create()
    {
        $this->validate($this->validationRules);

        $image      = $this->image->store('public/contacts');
        $imageParts = explode('/', $image);
        $image      = end($imageParts);

        ContactModel::create([
            'owner'      => auth()->id(),
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'mobile'     => $this->mobile,
            'email'      => $this->email,
            'image'      => $image,
        ]);

        $status = 'success';
        $message = 'Contact added successfully.';
        session()->flash('status', $status);
        session()->flash('message', $message);
        $this->dispatchBrowserEvent('alert-message', [
            'status' => $status,
            'message' => $message
        ]);
        $this->reset();
    }

    // Updates current contact
    public function update()
    {
        $rules = $this->validationRules;
        unset($rules['image']);
        $rules  = array_merge($rules, [
            'mobile' => 'string|unique:contacts,mobile,' . $this->currentContact->id,
            'email'  => 'string|unique:contacts,email,' . $this->currentContact->id
        ]);

        // dd($rules);

        $this->validate($rules);

        $image = $this->currentContact->image;

        // If we have new upload
        if ($this->image) {
            $this->validate(['image' => $this->validationRules['image']]);
            Storage::delete('public/contacts/' . $image);
            $image      = $this->image->store('public/contacts');
            $imageParts = explode('/', $image);
            $image      = end($imageParts);
        }

        $this->currentContact->update([
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'mobile'     => $this->mobile,
            'email'      => $this->email,
            'image'      => $image,
        ]);

        $status = 'success';
        $message = 'Contact updated successfully.';
        session()->flash('status', $status);
        session()->flash('message', $message);
        $this->dispatchBrowserEvent('alert-message', [
            'status' => $status,
            'message' => $message
        ]);
        $this->reset();
    }

    // Deletes a contact
    public function delete()
    {
        $this->currentContact->delete();

        $status = 'success';
        $message = 'Contact deleted successfully.';
        session()->flash('status', $status);
        session()->flash('message', $message);
        $this->dispatchBrowserEvent('alert-message', [
            'status' => $status,
            'message' => $message
        ]);
        $this->reset();
    }

    public function openContactModal($editMode = false, $contactId = null)
    {
        $this->reset();
        $this->resetErrorBag();
        if ($editMode) {
            $this->currentContact = ContactModel::findOrFail($contactId);
            $this->firstName      = $this->currentContact->first_name;
            $this->lastName       = $this->currentContact->last_name;
            $this->mobile         = $this->currentContact->mobile;
            $this->email          = $this->currentContact->email;
        }
        $this->setEditMode($editMode);
        $this->showContactModal = true;
    }

    public function openConfirmationModal(int $contactId)
    {
        $this->reset();
        $this->currentContact = ContactModel::findOrFail($contactId);
        $this->showConfirmationModal = true;
    }

    public function setEditMode(bool $mode)
    {
        $this->editMode = $mode;
    }

    public function cancel()
    {
        $this->reset();
    }

    public function getSearchResults($value)
    {
        if ($value) {
            $this->foundContacts = ContactModel::where('first_name', 'like', '%' . $value . '%')
                ->orWhere('last_name', 'like', '%' . $value . '%')
                ->paginate(env('PER_PAGE', 10));
        }
    }

    public function render()
    {
        return view('livewire.contact', [
            'foundContacts' => $this->foundContacts
        ]);
    }
}
