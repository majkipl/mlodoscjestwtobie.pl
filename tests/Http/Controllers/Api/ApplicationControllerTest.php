<?php

namespace Tests\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function getUser()
    {
        return factory(User::class)->create([
            'role' => UserRole::ADMIN
        ]);
    }

    /** @test */
    public function it_response_http_forbidden_if_without_token_for_list_application()
    {
        $response = $this->getJson(route('api.application'));
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_response_http_forbidden_if_token_wrong_for_list_application()
    {
        $queryParams = [
            'searchable' => ['id', 'firstname', 'lastname'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Str::random(32),
        ])->getJson(route('api.application') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_can_list_application()
    {
        $application = factory(Application::class)->times(5)->create();

        $queryParams = [
            'searchable' => ['id', 'firstname', 'lastname'],
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getUser()->api_token,
        ])->getJson(route('api.application') . '?' . http_build_query($queryParams));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($application->count(), 'rows');
    }
}
