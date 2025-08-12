<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_contact_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->for($user)->create();

        $this->assertTrue($contact->user->is($user));
    }

    public function test_a_contact_can_belong_to_many_companies()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->for($user)->create();
        $companies = Company::factory(2)->for($user)->create();

        $contact->companies()->attach($companies->pluck('id'));

        $this->assertCount(2, $contact->companies);
    }

    public function test_a_contact_can_have_many_deals()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->for($user)->create();
        $deals = Deal::factory(2)->for($user)->create();

        $contact->deals()->attach($deals->pluck('id'));

        $this->assertCount(2, $contact->deals);
    }
}
