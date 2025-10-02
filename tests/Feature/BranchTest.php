<?php
namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    private function loginUser()
    {
        $user = User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);
        return $user;
    }

    /** @test */
    public function user_can_add_branch()
    {
        $this->loginUser();

        $region = Region::create([
            'name' => 'Jawa Tengah',
            'code' => '2512',
        ]);

        $response = $this->post('/branch', [
            'name'      => 'Branch A',
            'address'   => 'Jl. Merdeka 123',
            'region_id' => $region->id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('branches', [
            'name'      => 'Branch A',
            'address'   => 'Jl. Merdeka 123',
            'region_id' => $region->id,
        ]);
    }

    /** @test */
    public function user_can_update_branch()
    {
        $this->loginUser();

        $region = Region::create([
            'name' => 'Jawa Barat',
            'code' => '1234',
        ]);

        $branch = Branch::create([
            'name'      => 'Branch Lama',
            'address'   => 'Jl. Lama',
            'region_id' => $region->id,
        ]);

        $response = $this->put('/branch/' . $branch->id, [
            'name'      => 'Branch Baru',
            'address'   => 'Jl. Baru',
            'region_id' => $region->id,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('branches', [
            'id'      => $branch->id,
            'name'    => 'Branch Baru',
            'address' => 'Jl. Baru',
        ]);
    }

    /** @test */
    public function user_can_delete_branch()
    {
        $this->loginUser();

        $region = Region::create([
            'name' => 'Banten',
            'code' => '9999',
        ]);

        $branch = Branch::create([
            'name'      => 'Branch B',
            'address'   => 'Jl. Raya',
            'region_id' => $region->id,
        ]);

        $response = $this->delete('/branch/' . $branch->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('branches', [
            'id' => $branch->id,
        ]);
    }

    /** @test */
    public function user_can_view_branch_list()
    {
        $this->loginUser();

        $region = Region::create([
            'name' => 'Sumatra Selatan',
            'code' => '8888',
        ]);

        Branch::create([
            'name'      => 'Branch C',
            'address'   => 'Jl. Kolonel',
            'region_id' => $region->id,
        ]);

        $response = $this->get('/branch');

        $response->assertStatus(200);
        $response->assertSee('Branch C');
    }

    /** @test */
    public function user_can_get_branches_by_region()
    {
        $this->loginUser();

        $region = Region::create([
            'name' => 'Kalimantan',
            'code' => '7777',
        ]);

        $branch = Branch::create([
            'name'      => 'Branch D',
            'address'   => 'Jl. Hutan',
            'region_id' => $region->id,
        ]);

        $response = $this->get('/branches-by-region/' . $region->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id'        => $branch->id,
            'name'      => 'Branch D',
            'address'   => 'Jl. Hutan',
            'region_id' => $region->id,
        ]);
    }
}
