<?php

namespace Tests\Http\Requests\Api;

use App\Http\Requests\Api\AddProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class AddProductRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function validation_pass_for_valid_data()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'name' => $this->faker->name,
            'category_id' => $category->id
        ];

        $validator = Validator::make($data, (new AddProductRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_missing()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'category_id' => $category->id
        ];

        $validator = Validator::make($data, (new AddProductRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_not_string()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'name' => 123,
            'category_id' => $category->id
        ];

        $validator = Validator::make($data, (new AddProductRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_exceeds_max_length()
    {
        $this->withoutExceptionHandling();

        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'name' => Str::random(256),
            'category_id' => $category->id
        ];

        $validator = Validator::make($data, (new AddProductRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_not_unique()
    {
        // Create product
        $existingProduct = factory(Product::class)->create();

        $category = factory(Category::class)->create();

        // Generate a request data with the same slug
        $data = [
            'name' => $existingProduct->name,
            'category_id' => $category->id, // This should be the same as the one created above
        ];

        // Create a mock request object
        $request = new AddProductRequest();
        $request->merge($data);

        // Validate the request
        $validator = Validator::make($data, $request->rules(), $request->messages());

        // Ensure the slug.unique validation rule fails
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_category_id_is_missing()
    {
        $data = [
            'name' => Str::random(16)
        ];

        $validator = Validator::make($data, (new AddProductRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_category_id_is_not_integer()
    {

        $data = [
            'name' => Str::random(16),
            'category_id' => 'asd'
        ];

        $validator = Validator::make($data, (new AddProductRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_category_id_is_not_exists()
    {
        // Generate a request data with the same slug
        $data = [
            'name' => Str::random(16),
            'category_id' => 999,
        ];

        // Create a mock request object
        $request = new AddProductRequest();
        $request->merge($data);

        // Validate the request
        $validator = Validator::make($data, $request->rules(), $request->messages());

        // Ensure the slug.unique validation rule fails
        $this->assertTrue($validator->fails());
    }
}
