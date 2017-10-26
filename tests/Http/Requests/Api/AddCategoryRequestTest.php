<?php

namespace Tests\Http\Requests\Api;

use App\Http\Requests\Api\AddCategoryRequest;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class AddCategoryRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function validation_pass_for_valid_data()
    {
        $data = [
            'name' => $this->faker->name,
        ];

        $validator = Validator::make($data, (new AddCategoryRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_missing()
    {

        $data = [];

        $validator = Validator::make($data, (new AddCategoryRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_not_string()
    {
        $data = [
            'name' => 123,
        ];

        $validator = Validator::make($data, (new AddCategoryRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_name_is_exceeds_max_length()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => Str::random(200),
        ];

        $validator = Validator::make($data, (new AddCategoryRequest())->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_slug_is_not_string()
    {
        $data = [
            'name' => Str::random(16),
            'slug' => 123,
        ];

        $request = new AddCategoryRequest();
        $request->merge($data);

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_slug_is_exceeds_max_length()
    {
        $data = [
            'name' => Str::random(16),
            'slug' => Str::random(200),
        ];

        $request = new AddCategoryRequest();
        $request->merge($data); // Wprowadź dane do instancji formularza

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function validation_fails_if_slug_is_not_unique()
    {
        // Create category with slug
        $existingCategory = factory(Category::class)->create();

        // Generate a request data with the same slug
        $data = [
            'name' => $this->faker->word,
            'slug' => $existingCategory->slug, // This should be the same as the one created above
        ];

        // Create a mock request object
        $request = new AddCategoryRequest();
        $request->merge($data);

        // Validate the request
        $validator = Validator::make($data, $request->rules(), $request->messages());

        // Ensure the slug.unique validation rule fails
        $this->assertTrue($validator->fails());
    }
}
