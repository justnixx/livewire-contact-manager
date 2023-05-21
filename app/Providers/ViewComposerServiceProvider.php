<?php

namespace App\Providers;

use App\Models\Contact;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if ($view->getName() === 'livewire.contact') {
                $contacts = Contact::where('owner', auth()->id())->orderBy('first_name')->paginate(10);
            } else {
                $contacts = Contact::where('owner', auth()->id())->get();
            }

            $view->with('contacts', $contacts);
        });
    }
}
