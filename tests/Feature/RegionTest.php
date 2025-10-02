<?php
namespace Tests\Feature;

use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_region()
    {
        $user = User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/region', [
            'name' => 'Jawa Tengah',
            'code' => '2512',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('regions', [
            'name' => 'Jawa Tengah',
            'code' => '2512',
        ]);
    }

    /** @test */
    public function user_can_delete_region()
    {
        $user = User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $region = Region::create([
            'name' => 'Banten',
            'code' => '9999',
        ]);

        $response = $this->delete('/region/' . $region->id);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('regions', [
            'id' => $region->id,
        ]);
    }

    /** @test */
    public function user_can_update_region()
    {
        $user = User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $region = Region::create([
            'name' => 'Jawa Barat',
            'code' => '1234',
        ]);

        $response = $this->put('/region/' . $region->id, [
            'name' => 'Jawa Barat Updated',
            'code' => '5678',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('regions', [
            'id'   => $region->id,
            'name' => 'Jawa Barat Updated',
            'code' => '5678',
        ]);
    }

    /** @test */
    public function user_can_view_region_list()
    {
        $user = User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        Region::create([
            'name' => 'Sumatra Selatan',
            'code' => '8888',
        ]);

        $response = $this->get('/region');

        $response->assertStatus(200);
        $response->assertSee('Sumatra Selatan');
    }
}
