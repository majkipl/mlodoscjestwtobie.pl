<?php

namespace Tests\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function getUser()
    {
        return factory(User::class)->create([
            'role' => UserRole::ADMIN
        ]);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_list_product()
    {
        $response = $this->get(route('api.product'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_category()
    {
        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.product') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_list_product()
    {
        $products = factory(Product::class)->times(5)->create();

        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->getJson(route('api.product') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($products->count(), 'rows');
    }

    /** @test */
    public function is_no_valid_params_for_list_product()
    {
        $queryParams = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->getJson(route('api.product') . '?' . http_build_query($queryParams));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_add_product()
    {
        $response = $this->post(route('api.product.add'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_add_product()
    {
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'New Product',
            'category_id' => $category->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->postJson(route('api.product.add'), $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_add_product()
    {
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'New Product',
            'category_id' => $category->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->postJson(route('api.product.add'), $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function is_no_valid_params_for_add_product()
    {
        $data = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->postJson(route('api.product.add'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_update_product()
    {
        $response = $this->put(route('api.product.update'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_update_product()
    {
        $product = factory(Product::class)->create();
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'New Product',
            'category_id' => $category->id,
            'id' => $product->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->putJson(route('api.product.update'), $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_update_product()
    {
        $product = factory(Product::class)->create();
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'New Product',
            'category_id' => $category->id,
            'id' => $product->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->putJson(route('api.product.update'), $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseHas('products', $data);
    }

    /** @test */
    public function is_no_valid_params_for_update_product()
    {
        $data = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->putJson(route('api.product.update'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_delete_product()
    {
        $product = factory(Product::class)->create();

        $response = $this->delete(route('api.product.delete', ['product' => $product->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_deletet_product()
    {
        $product = factory(Product::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->deleteJson(route('api.product.delete', ['product' => $product->id]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_delete_product()
    {
        $product = factory(Product::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->deleteJson(route('api.product.delete', ['product' => $product->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function validation_fails_if_id_not_exist_for_delete_product()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->deleteJson(route('api.product.delete', ['product' => '']));

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /** @test */
    public function it_can_list_product_for_category_id()
    {
        $this->withoutExceptionHandling();

        $category = factory(Category::class)->create();

        $products = factory(Product::class)->times(5)->create([
           'category_id' => $category->id
        ]);

        $response = $this->getJson(route('api.products.category', ['category' => $category->id]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($products->count(), 'rows');
    }

    /** @test */
    public function validation_fails_if_category_id_not_exist_for_list_product()
    {
        $response = $this->getJson(route('api.products.category', ['category' => '']));

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

}
