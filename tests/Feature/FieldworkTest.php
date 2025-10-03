<?php
namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Fieldwork;
use App\Models\FieldworkCategory;
use App\Models\FieldworkStatus;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldworkTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $region;
    protected $branch;
    protected $category;
    protected $status;

    protected function setUp(): void
    {
        parent::setUp();

        // User login (dummy, non-admin)
        $this->user = User::factory()->create(['is_admin' => 0]);
        $this->actingAs($this->user);

        // Region dummy
        $this->region = Region::create([
            'name' => 'Jawa Barat',
            'code' => '1234',
        ]);

        // Branch dummy
        $this->branch = Branch::create([
            'name'      => 'Cabang Bandung',
            'region_id' => $this->region->id,
            'address'   => 'Jl. Testing No. 123', // tambahkan ini biar lolos
        ]);


        // Category dummy
        $this->category = FieldworkCategory::create([
            'name' => 'Survey',
        ]);

        // Status dummy
        $this->status = FieldworkStatus::create([
            'name' => 'On Progress',
        ]);
    }

    /** @test */
    public function user_can_create_fieldwork()
    {
        $response = $this->post('/fieldwork', [
            'description' => 'Testing fieldwork',
            'note'        => 'Catatan awal',
            'branch_id'   => $this->branch->id,
            'category_id' => $this->category->id,
            'status_id'   => $this->status->id,
            'start_date'  => '2025-10-01',
            'end_date'    => '2025-10-05',
            'users'       => [$this->user->id],
        ]);

        $response->assertRedirect(route('fieldwork.index'));
        $this->assertDatabaseHas('fieldworks', [
            'description' => 'Testing fieldwork',
            'branch_id'   => $this->branch->id,
            'category_id' => $this->category->id,
            'status_id'   => $this->status->id,
        ]);
        $this->assertDatabaseHas('user_fieldworks', [
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function user_can_update_fieldwork()
    {
        $fieldwork = Fieldwork::create([
            'description' => 'Old description',
            'note'        => 'Old note',
            'branch_id'   => $this->branch->id,
            'category_id' => $this->category->id,
            'status_id'   => $this->status->id,
            'start_date'  => '2025-10-01',
            'end_date'    => '2025-10-02',
        ]);
        $fieldwork->users()->sync([$this->user->id]);

        $response = $this->put('/fieldwork/' . $fieldwork->id, [
            'description' => 'Updated description',
            'note'        => 'Updated note',
            'branch_id'   => $this->branch->id,
            'category_id' => $this->category->id,
            'status_id'   => $this->status->id,
            'start_date'  => '2025-10-03',
            'end_date'    => '2025-10-05',
            'users'       => [$this->user->id],
        ]);

        $response->assertRedirect(route('fieldwork.index'));
        $this->assertDatabaseHas('fieldworks', [
            'id'          => $fieldwork->id,
            'description' => 'Updated description',
            'note'        => 'Updated note',
        ]);
    }

    /** @test */
    public function user_can_delete_fieldwork()
    {
        $fieldwork = Fieldwork::create([
            'description' => 'Delete this',
            'note'        => 'Soon to be deleted',
            'branch_id'   => $this->branch->id,
            'category_id' => $this->category->id,
            'status_id'   => $this->status->id,
            'start_date'  => '2025-10-01',
            'end_date'    => '2025-10-02',
        ]);
        $fieldwork->users()->sync([$this->user->id]);

        $response = $this->delete('/fieldwork/' . $fieldwork->id);

        $response->assertRedirect(route('fieldwork.index'));
        $this->assertDatabaseMissing('fieldworks', [
            'id' => $fieldwork->id,
        ]);
    }
}
