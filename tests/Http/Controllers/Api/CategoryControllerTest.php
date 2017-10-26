<?php

namespace Tests\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function getUser()
    {
        return factory(User::class)->create([
            'role' => UserRole::ADMIN
        ]);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_list_category()
    {
        $response = $this->get(route('api.category'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_category()
    {
        $queryParams = [
            'searchable' => ['id', 'name', 'slug'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.category') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_list_category()
    {
        $categories = factory(Category::class)->times(5)->create();

        $queryParams = [
            'searchable' => ['id', 'name', 'slug'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->getJson(route('api.category') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($categories->count(), 'rows');
    }

    /** @test */
    public function is_no_valid_params_for_list_category()
    {
        $queryParams = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->getJson(route('api.category') . '?' . http_build_query($queryParams));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_add_category()
    {
        $response = $this->post(route('api.category.add'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_add_category()
    {
        $name = 'New Category';

        $data = [
            'name' => $name,
            'slug' => Str::slug($name)
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->postJson(route('api.category.add'), $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_add_category()
    {
        $name = 'New Category';

        $data = [
            'name' => $name,
            'slug' => Str::slug($name)
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->postJson(route('api.category.add'), $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseHas('categories', $data);
    }

    /** @test */
    public function is_no_valid_params_for_add_category()
    {
        $data = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->postJson(route('api.category.add'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_update_category()
    {
        $response = $this->put(route('api.category.update'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_update_category()
    {
        $category = factory(Category::class)->create();

        $name = 'New Category';

        $data = [
            'name' => $name,
            'slug' => Str::slug($name),
            'id' => $category->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->putJson(route('api.category.update'), $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_update_category()
    {
        $category = factory(Category::class)->create();

        $name = 'New Category';

        $data = [
            'name' => $name,
            'slug' => Str::slug($name),
            'id' => $category->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->putJson(route('api.category.update'), $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseHas('categories', $data);
    }

    /** @test */
    public function is_no_valid_params_for_update_category()
    {
        $data = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->putJson(route('api.category.update'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_delete_category()
    {
        $category = factory(Category::class)->create();

        $response = $this->delete(route('api.category.delete', ['category' => $category->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_delete_category()
    {
        $category = factory(Category::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->deleteJson(route('api.category.delete', ['category' => $category->id]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_delete_category()
    {
        $category = factory(Category::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->deleteJson(route('api.category.delete', ['category' => $category->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function validation_fails_if_id_not_exist_for_delete_category()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->deleteJson(route('api.category.delete', ['category' => '']));

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
