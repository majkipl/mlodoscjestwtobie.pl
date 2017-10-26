<?php

namespace Tests\Http\Requests\Api;

use App\Http\Requests\Api\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class UpdateCategoryRequestTest extends AddCategoryRequestTest
{
    /** @test */
    public function validation_pass_for_valid_data()
    {
        $category = factory(Category::class)->create();

        $data = [
            'name' => $this->faker->name,
            'id' => $category->id,
        ];

        $validator = Validator::make($data, (new UpdateCategoryRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_id_is_missing()
    {

        $data = [
            'name' => $this->faker->name,
        ];

        $validator = Validator::make($data, (new UpdateCategoryRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_is_is_not_integer()
    {
        $data = [
            'name' => $this->faker->name,
            'id' => 'lorem'
        ];

        $validator = Validator::make($data, (new UpdateCategoryRequest())->rules());

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
        $request = new UpdateCategoryRequest();
        $request->merge($data);

        // Validate the request
        $validator = Validator::make($data, $request->rules(), $request->messages());

        // Ensure the slug.unique validation rule fails
        $this->assertTrue($validator->fails());
    }
}
