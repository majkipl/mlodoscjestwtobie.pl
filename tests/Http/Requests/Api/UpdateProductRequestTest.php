<?php

namespace Tests\Http\Requests\Api;

use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class UpdateProductRequestTest extends AddProductRequestTest
{
    /** @test */
    public function validation_pass_for_valid_data()
    {
        $product = factory(Product::class)->create();

        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'name' => $this->faker->name,
            'category_id' => $category->id,
            'id' => $product->id,
        ];

        $validator = Validator::make($data, (new UpdateProductRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_id_is_missing()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'name' => $this->faker->name,
            'category_id' => $category->id
        ];

        $validator = Validator::make($data, (new UpdateProductRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_id_is_not_integer()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'name' => $this->faker->name,
            'category_id' => $category->id,
            'id' => 'lorem'
        ];

        $validator = Validator::make($data, (new UpdateProductRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_id_is_not_exists()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        // Generate a request data with the same name and id
        $data = [
            'name' => $this->faker->name,
            'category_id' => $category->id,
            'id' => 999,
        ];

        // Create a mock request object
        $request = new UpdateProductRequest();
        $request->merge($data);

        // Validate the request
        $validator = Validator::make($data, $request->rules(), $request->messages());

        // Ensure the slug.unique validation rule fails
        $this->assertTrue($validator->fails());
    }
}
