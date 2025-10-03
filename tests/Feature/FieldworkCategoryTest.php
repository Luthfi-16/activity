<?php
namespace Tests\Feature;

use App\Models\FieldworkCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldworkCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Buat user dummy dan login otomatis di setiap test
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /** @test */
    public function user_can_view_category_index()
    {
        $category = FieldworkCategory::create([
            'name'        => 'Category A',
            'description' => 'Desc A',
        ]);

        $response = $this->get('/fieldwork_category');
        $response->assertStatus(200);
        $response->assertSee('Category A');
    }

    /** @test */
    public function user_can_create_category()
    {
        $response = $this->post('/fieldwork_category', [
            'name'        => 'Category B',
            'description' => 'Desc B',
        ]);

        $response->assertRedirect('/fieldwork_category');
        $this->assertDatabaseHas('fieldwork_categories', [
            'name'        => 'Category B',
            'description' => 'Desc B',
        ]);
    }

    /** @test */
    public function user_can_view_category_detail()
    {
        $category = FieldworkCategory::create([
            'name'        => 'Category C',
            'description' => 'Desc C',
        ]);

        $response = $this->get('/fieldwork_category/' . $category->id);
        $response->assertStatus(200);
        $response->assertSee('Category C');
    }

    /** @test */
    public function user_can_update_category()
    {
        $category = FieldworkCategory::create([
            'name'        => 'Category D',
            'description' => 'Desc D',
        ]);

        $response = $this->put('/fieldwork_category/' . $category->id, [
            'name'        => 'Category D Updated',
            'description' => 'Desc D Updated',
        ]);

        $response->assertRedirect('/fieldwork_category');
        $this->assertDatabaseHas('fieldwork_categories', [
            'id'          => $category->id,
            'name'        => 'Category D Updated',
            'description' => 'Desc D Updated',
        ]);
    }

    /** @test */
    public function user_can_delete_category()
    {
        $category = FieldworkCategory::create([
            'name'        => 'Category E',
            'description' => 'Desc E',
        ]);

        $response = $this->delete('/fieldwork_category/' . $category->id);

        $response->assertRedirect('/fieldwork_category');
        $this->assertDatabaseMissing('fieldwork_categories', [
            'id' => $category->id,
        ]);
    }
}
