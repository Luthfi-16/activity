<?php
namespace Tests\Feature;

use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPhoneTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat user dummy untuk login
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function user_can_view_userphone_index()
    {
        $phone = UserPhone::create([
            'number'  => '08123456789',
            'name'    => 'Phone A',
            'user_id' => $this->user->id,
        ]);

        $response = $this->get('/userphone');
        $response->assertStatus(200);
        $response->assertSee('Phone A');
    }

    /** @test */
    public function user_can_create_userphone()
    {
        $response = $this->post('/userphone', [
            'number'  => '08198765432',
            'name'    => 'Phone B',
            'user_id' => $this->user->id,
        ]);

        $response->assertRedirect('/userphone');
        $this->assertDatabaseHas('user_phones', [
            'number'  => '08198765432',
            'name'    => 'Phone B',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function user_can_view_userphone_detail()
    {
        $phone = UserPhone::create([
            'number'  => '08122223333',
            'name'    => 'Phone C',
            'user_id' => $this->user->id,
        ]);

        $response = $this->get('/userphone/' . $phone->id);
        $response->assertStatus(200);
        $response->assertSee('Phone C');
    }

    /** @test */
    public function user_can_update_userphone()
    {
        $phone = UserPhone::create([
            'number'  => '08144445555',
            'name'    => 'Phone D',
            'user_id' => $this->user->id,
        ]);

        $response = $this->put('/userphone/' . $phone->id, [
            'number'  => '08199990000',
            'name'    => 'Phone D Updated',
            'user_id' => $this->user->id,
        ]);

        $response->assertRedirect('/userphone');
        $this->assertDatabaseHas('user_phones', [
            'id'     => $phone->id,
            'number' => '08199990000',
            'name'   => 'Phone D Updated',
        ]);
    }

    /** @test */
    public function user_can_delete_userphone()
    {
        $phone = UserPhone::create([
            'number'  => '08166667777',
            'name'    => 'Phone E',
            'user_id' => $this->user->id,
        ]);

        $response = $this->delete('/userphone/' . $phone->id);

        $response->assertRedirect('/userphone');
        $this->assertDatabaseMissing('user_phones', [
            'id' => $phone->id,
        ]);
    }
}
