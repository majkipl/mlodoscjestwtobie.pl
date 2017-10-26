<?php

namespace Tests\Http\Requests\Api;

use App\Http\Requests\Api\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;

class UpdateShopRequestTest extends AddShopRequestTest
{
    /** @test */
    public function validation_pass_for_valid_data()
    {
        $shop = factory(Shop::class)->create();
        $data = [
            'name' => $this->faker->name,
            'id' => $shop->id,
        ];

        $validator = Validator::make($data, (new UpdateShopRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_id_is_missing()
    {

        $data = [
            'name' => $this->faker->name,
        ];

        $validator = Validator::make($data, (new UpdateShopRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_is_is_not_integer()
    {
        $data = [
            'name' => $this->faker->name,
            'id' => 'lorem'
        ];

        $validator = Validator::make($data, (new UpdateShopRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_id_is_not_exists()
    {
        // Generate a request data with the same name and id
        $data = [
            'name' => $this->faker->name,
            'id' => 999,
        ];

        // Create a mock request object
        $request = new UpdateShopRequest();
        $request->merge($data);

        // Validate the request
        $validator = Validator::make($data, $request->rules(), $request->messages());

        // Ensure the slug.unique validation rule fails
        $this->assertTrue($validator->fails());
    }
}
