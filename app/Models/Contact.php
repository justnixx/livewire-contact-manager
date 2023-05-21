<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'owner',
        'first_name',
        'last_name',
        'email',
        'mobile'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($contact) {
            if ($contact->image) {
                Storage::delete('public/contacts/' . $contact->image);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner');
    }
}
