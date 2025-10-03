<?php
namespace Tests\Feature;

use App\Models\FieldworkStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldworkStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_fieldwork_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/fieldwork_statuses', [
            'name'        => 'On Progress',
            'description' => 'Fieldwork sedang berlangsung',
        ]);

        $response->assertStatus(302); // redirect
        $this->assertDatabaseHas('fieldwork_statuses', [
            'name'        => 'On Progress',
            'description' => 'Fieldwork sedang berlangsung',
        ]);
    }

    /** @test */
    public function user_can_update_fieldwork_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = FieldworkStatus::create([
            'name'        => 'Pending',
            'description' => 'Menunggu persetujuan',
        ]);

        $response = $this->put('/fieldwork_statuses/' . $status->id, [
            'name'        => 'Approved',
            'description' => 'Sudah disetujui',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('fieldwork_statuses', [
            'id'          => $status->id,
            'name'        => 'Approved',
            'description' => 'Sudah disetujui',
        ]);
    }

    /** @test */
    public function user_can_delete_fieldwork_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = FieldworkStatus::create([
            'name'        => 'Rejected',
            'description' => 'Ditolak',
        ]);

        $response = $this->delete('/fieldwork_statuses/' . $status->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('fieldwork_statuses', [
            'id' => $status->id,
        ]);
    }

    /** @test */
    public function user_can_view_fieldwork_status_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        FieldworkStatus::create([
            'name'        => 'Finished',
            'description' => 'Sudah selesai',
        ]);

        $response = $this->get('/fieldwork_statuses');

        $response->assertStatus(200);
        $response->assertSee('Finished');
    }

    /** @test */
    public function user_can_view_single_fieldwork_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = FieldworkStatus::create([
            'name'        => 'In Review',
            'description' => 'Sedang ditinjau',
        ]);

        $response = $this->get('/fieldwork_statuses/' . $status->id);

        $response->assertStatus(200);
        $response->assertSee('In Review');
    }
}
