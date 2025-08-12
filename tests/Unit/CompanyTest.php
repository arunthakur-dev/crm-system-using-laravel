<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_company_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();

        $this->assertTrue($company->user->is($user));
    }

    public function test_a_company_can_have_many_contacts()
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();
        $contacts = Contact::factory(3)->for($user)->create();

        $company->contacts()->attach($contacts->pluck('id'));

        $this->assertCount(3, $company->contacts);
    }

    public function test_a_company_can_have_many_deals()
    {
        $user = User::factory()->create();
        $company = Company::factory()->for($user)->create();
        $deals = Deal::factory(2)->for($user)->create();

        $company->deals()->attach($deals->pluck('id'));

        $this->assertCount(2, $company->deals);
    }
}
