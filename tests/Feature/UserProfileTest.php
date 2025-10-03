<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // bikin user dummy
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function user_can_view_their_profile_page_even_without_profile()
    {
        $response = $this->get('/profile');
        $response->assertStatus(200);
        $response->assertSee($this->user->name); // karena view biasanya pakai auth()->user()->name
    }

    /** @test */
    public function user_can_create_profile()
    {
        $response = $this->post('/profile/store', [
            'nik'        => '1234567890',
            'name'       => 'Test User',
            'gender'     => 'L',
            'birthplace' => 'Jakarta',
            'birthday'   => '2000-01-01',
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('user_profiles', [
            'nik'     => '1234567890',
            'name'    => 'Test User',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function user_can_update_profile()
    {
        $profile = UserProfile::create([
            'nik'        => '9876543210',
            'name'       => 'Old Name',
            'gender'     => 'P',
            'birthplace' => 'Bandung',
            'birthday'   => '1999-12-31',
            'user_id'    => $this->user->id,
        ]);

        $response = $this->put('/profile/update', [
            'nik'        => '9876543210', // tetap sama
            'name'       => 'New Name',
            'gender'     => 'L',
            'birthplace' => 'Surabaya',
            'birthday'   => '1998-05-05',
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('user_profiles', [
            'id'         => $profile->id,
            'name'       => 'New Name',
            'birthplace' => 'Surabaya',
        ]);
    }
}
