<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        // Create default user
        $user                            = new User();
        $user->name                      = 'NIXX';
        $user->email                     = 'hello@nixx.dev';
        $user->email_verified_at         = now();
        $user->password                  = Hash::make('password');
        $user->two_factor_secret         = null;
        $user->two_factor_recovery_codes = null;
        $user->remember_token            = Str::random(10);
        $user->profile_photo_path        = null;
        $user->current_team_id           = null;
        $user->save();


        // Create 20 contacts with the default user as the owner
        for ($i = 0; $i < 20; $i++) {
            Contact::create([
                'owner'      => $user->id,
                'image'      => $faker->image('storage/app/public/contacts', 200, 200, 'people', false),
                'first_name' => $faker->firstName(),
                'last_name'  => $faker->lastName(),
                'email'      => $faker->unique()->safeEmail(),
                'mobile'     => $faker->phoneNumber(),
            ]);
        }
    }
}
