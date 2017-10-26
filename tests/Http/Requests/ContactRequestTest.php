<?php

namespace Tests\Http\Requests;

use App\Http\Requests\ContactRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\Feature\Api\Validation\ValidationTestCase;

class ContactRequestTest extends ValidationTestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function validation_pass_for_valid_data()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'message' => $this->faker->text(4096, true),
        ];

        $this->runValidationTest($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_name_is_not_exists()
    {
        $data = [
            'email' => $this->faker->email,
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_name_is_not_a_string()
    {
        $data = [
            'name' => $this->faker->randomDigit,
            'email' => $this->faker->email,
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_name_is_less_that_min_length()
    {
        $data = [
            'name' => $this->faker->randomLetter,
            'email' => $this->faker->email,
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_name_is_exceeds_max_length()
    {
        $data = [
            'name' => Str::random(129),
            'email' => $this->faker->email,
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_email_is_not_exists()
    {
        $data = [
            'name' => $this->faker->name,
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_email_is_not_a_string()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->randomDigit,
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_email_is_exceeds_max_length()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => Str::random(256),
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_email_is_not_rfc_dns()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->text(255, true),
            'message' => $this->faker->text(4096, true),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_message_is_not_exists()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_message_is_not_a_string()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'message' => $this->faker->randomDigit,
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }

    /** @test */
    public function validation_fails_if_message_is_exceeds_max_length()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'message' => Str::random(4097),
        ];

        $this->expectValidationException($data, ContactRequest::class);
    }
}
