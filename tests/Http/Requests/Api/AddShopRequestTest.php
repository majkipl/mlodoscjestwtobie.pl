<?php

namespace Tests\Http\Requests\Api;

use App\Http\Requests\Api\AddShopRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class AddShopRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function validation_pass_for_valid_data()
    {
        $data = [
            'name' => $this->faker->name,
        ];

        $validator = Validator::make($data, (new AddShopRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_missing()
    {

        $data = [];

        $validator = Validator::make($data, (new AddShopRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_not_string()
    {
        $data = [
            'name' => 123,
        ];

        $validator = Validator::make($data, (new AddShopRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_exceeds_max_length()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => Str::random(200),
        ];

        $validator = Validator::make($data, (new AddShopRequest())->rules());

        $this->assertTrue($validator->fails());
    }
}
