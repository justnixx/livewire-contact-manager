<?php

namespace App\Http\Livewire;

use App\Models\Contact as ContactModel;
use Livewire\Component;


class SearchContacts extends Component
{
    public $search;

    protected $queryString = ['search' => ['except' => '', 'as' => 'f']];

    public function updatedSearch($value): void
    {
        $this->emitUp('searchUpdated', $value);
    }

    public function render()
    {
        return view('livewire.search-contacts');
    }
}
