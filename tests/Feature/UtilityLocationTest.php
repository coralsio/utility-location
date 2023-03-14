<?php

namespace Tests\Feature;

use Corals\Utility\Location\Models\Location;
use Corals\Settings\Facades\Modules;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UtilityLocationTest extends TestCase
{
    use DatabaseTransactions;

    protected $location;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'superuser');
        })->first();
        Auth::loginUsingId($user->id);
    }

    public function test_utility_location_store()
    {
        $modules = [
            'Classified' => 'corals-classified',
            'TroubleTicket' => 'corals-trouble-ticket',
            'Directory' => 'corals-directory',
            'Marketplace' => 'corals-marketplace',
            'CMS' => 'corals-cms',
        ];

        $locations = ['palestine', 'brazil', 'france', 'turkey', 'australia'];
        $active = false;
        foreach ($modules as $module => $code) {
            if (Modules::isModuleActive($code)) {
                $active = true;
                $location = array_rand($locations);
                $response = $this->post('utilities/address/locations', [
                    "name" => $locations[$location],
                    "slug" => $locations[$location],
                    "module" => $module,
                    "address" => $locations[$location],
                    "lat" => random_int(50, 500),
                    "long" => random_int(50, 500),
                    "status" => "active",
                ]);

                $this->location = Location::query()->first();

                $response->assertDontSee('The given data was invalid')
                    ->assertRedirect('utilities/address/locations');


                $this->assertDatabaseHas('utility_locations', [
                    "name" => $this->location->name,
                    "slug" => $this->location->slug,
                    "module" => $this->location->module,
                    "status" => $this->location->status,
                    "address" => $this->location->address,
                    "lat" => $this->location->lat,
                    "long" => $this->location->long,
                ]);
            }
        }

        if (! $active) {
            $location = array_rand($locations);
            $response = $this->post('utilities/address/locations', [
                "name" => $locations[$location],
                "slug" => $locations[$location],
                "address" => $locations[$location],
                "lat" => random_int(50, 500),
                "long" => random_int(50, 500),
                "status" => "active",
            ]);
            $this->location = Location::query()->first();

            $response->assertDontSee('The given data was invalid')
                ->assertRedirect('utilities/address/locations');


            $this->assertDatabaseHas('utility_locations', [
                "name" => $this->location->name,
                "slug" => $this->location->slug,
                "module" => $this->location->module,
                "status" => $this->location->status,
                "address" => $this->location->address,
                "lat" => $this->location->lat,
                "long" => $this->location->long,
            ]);
        }
    }

    public function test_utility_location_edit()
    {
        $this->test_utility_location_store();

        if ($this->location) {
            $response = $this->get('utilities/address/locations/' . $this->location->hashed_id . '/edit');

            $response->assertStatus(200)->assertViewIs('utility-location::locations.create_edit');
        }
        $this->assertTrue(true);
    }

    public function test_utility_location_update()
    {
        $this->test_utility_location_store();

        if ($this->location) {
            $response = $this->put('utilities/address/locations/' . $this->location->hashed_id, [
                "name" => $this->location->name,
                "slug" => $this->location->slug,
                "address" => $this->location->address,
                "lat" => $this->location->lat,
                "long" => $this->location->long,
                "status" => 'inactive',]);

            $response->assertRedirect('utilities/address/locations');

            $this->assertDatabaseHas('utility_locations', [
                "name" => $this->location->name,
                "slug" => $this->location->slug,
                "module" => $this->location->module,
                "address" => $this->location->address,
                "lat" => $this->location->lat,
                "long" => $this->location->long,
                "status" => 'inactive',
            ]);
        }
        $this->assertTrue(true);
    }

    public function test_utility_location_delete()
    {
        $this->test_utility_location_store();

        if ($this->location) {
            $response = $this->delete('utilities/address/locations/' . $this->location->hashed_id);

            $response->assertStatus(200)->assertSeeText('Location has been deleted successfully.');

            $this->isSoftDeletableModel(Location::class);
            $this->assertDatabaseMissing('utility_locations', [
                "name" => $this->location->name,
                "slug" => $this->location->slug,
                "module" => $this->location->module,
                "address" => $this->location->address,
                "lat" => $this->location->lat,
                "long" => $this->location->long,
                "status" => $this->location->status, ]);
        }
        $this->assertTrue(true);
    }
}
