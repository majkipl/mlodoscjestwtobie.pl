<?php

namespace Tests\Feature\Api\Authenticated;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthenticatedTestCase extends TestCase
{

    protected $user;

    /**
     * @return $this
     */
    public function authenticated(): AuthenticatedTestCase
    {
        $this->user = factory(User::class)->create([
            'role' => UserRole::ADMIN
        ]);

        $this->actingAs($this->user);

        return $this;
    }

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function user_has_not_access(string $route, array $params = [])
    {
        $response = $this->get(route($route, $params));
        $response->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }

    /**
     * @param string $route
     * @param array $params
     * @return void
     */
    public function user_has_access(string $route, array $params = [])
    {
        $response = $this->authenticated()->get(route($route, $params));
        $response->assertStatus(Response::HTTP_OK);
    }
}
