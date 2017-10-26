<?php

namespace Tests\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;

    public function getUser()
    {
        return factory(User::class)->create([
            'role' => UserRole::ADMIN
        ]);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_list_shop()
    {
        $response = $this->get(route('api.shop'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_shop()
    {
        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.shop') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_list_shop()
    {
        $shops = factory(Shop::class)->times(5)->create();

        $queryParams = [
            'searchable' => ['id', 'name'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->getJson(route('api.shop') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($shops->count(), 'rows');
    }

    /** @test */
    public function is_no_valid_params_for_list_shop()
    {
        $queryParams = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->getJson(route('api.shop') . '?' . http_build_query($queryParams));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_add_shop()
    {
        $response = $this->post(route('api.shop.add'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_add_shop()
    {
        $data = [
            'name' => 'New Shop'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->postJson(route('api.shop.add'), $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_add_shop()
    {
        $data = [
            'name' => 'New Shop'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->postJson(route('api.shop.add'), $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseHas('shops', $data);
    }

    /** @test */
    public function is_no_valid_params_for_add_shop()
    {
        $data = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->postJson(route('api.shop.add'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_update_shop()
    {
        $response = $this->put(route('api.shop.update'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_update_shop()
    {
        $shop = factory(Shop::class)->create();

        $data = [
            'name' => 'New Shop',
            'id' => $shop->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->putJson(route('api.shop.update'), $data);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_update_shop()
    {
        $shop = factory(Shop::class)->create();

        $data = [
            'name' => 'New Shop',
            'id' => $shop->id
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->putJson(route('api.shop.update'), $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseHas('shops', $data);
    }

    /** @test */
    public function is_no_valid_params_for_update_shop()
    {
        $data = [];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->putJson(route('api.shop.update'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_delete_shop()
    {
        $shop = factory(Shop::class)->create();

        $response = $this->delete(route('api.shop.delete', ['shop' => $shop->id]));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_delete_shop()
    {
        $shop = factory(Shop::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->deleteJson(route('api.shop.delete', ['shop' => $shop->id]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_delete_shop()
    {
        $shop = factory(Shop::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->deleteJson(route('api.shop.delete', ['shop' => $shop->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success'
            ]);

        $this->assertDatabaseMissing('shops', ['id' => $shop->id]);
    }

    /** @test */
    public function validation_fails_if_id_not_exist_for_delete_shop()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->deleteJson(route('api.shop.delete', ['shop' => '']));

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}

