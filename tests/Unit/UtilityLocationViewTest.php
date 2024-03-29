<?php

namespace Tests\Feature;

use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UtilityLocationViewTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'superuser');
        })->first();
        Auth::loginUsingId($user->id);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_utility_location_view()
    {
        $response = $this->get('utilities/address/locations');

        $response->assertStatus(200)->assertViewIs('utility-location::locations.index');
    }

    public function test_utility_location_create()
    {
        $response = $this->get('utilities/address/locations/create');

        $response->assertViewIs('utility-location::locations.create_edit')->assertStatus(200);
    }

    public function test_utility_location_bulk_action()
    {
        $response = $this->post('utilities/address/locations/bulk-action', [
            'action' => 'active',]);


        $response->assertSeeText('message')
            ->assertDontSee('There is no permission update status');
    }
}
