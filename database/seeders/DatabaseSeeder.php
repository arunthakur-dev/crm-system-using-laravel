<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $companies = Company::factory(20)->for($user)->create();
    $contacts = Contact::factory(20)->for($user)->create();
    $deals = Deal::factory(20)->for($user)->create();

    // Company - Contact
    $companies->each(function ($company) use ($contacts) {
        $company->contacts()->attach($contacts->random(5)->pluck('id'));
    });

    // Company - Deal
    $companies->each(function ($company) use ($deals) {
        $company->deals()->attach($deals->random(5)->pluck('id'));
    });

    // Contact - Deal
    $contacts->each(function ($contact) use ($deals) {
        $contact->deals()->attach($deals->random(5)->pluck('id'));
    });
    }

}
