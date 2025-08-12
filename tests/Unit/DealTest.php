<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DealTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_deal_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $deal = Deal::factory()->for($user)->create();

        $this->assertTrue($deal->user->is($user));
    }

    public function test_a_deal_can_belong_to_many_companies()
    {
        $user = User::factory()->create();
        $deal = Deal::factory()->for($user)->create();
        $companies = Company::factory(2)->for($user)->create();

        $deal->companies()->attach($companies->pluck('id'));

        $this->assertCount(2, $deal->companies);
    }

    public function test_a_deal_can_have_many_contacts()
    {
        $user = User::factory()->create();
        $deal = Deal::factory()->for($user)->create();
        $contacts = Contact::factory(3)->for($user)->create();

        $deal->contacts()->attach($contacts->pluck('id'));

        $this->assertCount(3, $deal->contacts);
    }
}
