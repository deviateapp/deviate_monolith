<?php

namespace Tests\Gateway\Registration;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /** @test */
    public function a_new_user_can_register()
    {
        $response = $this->postJson('/api/registration/register', [
            'forename'     => 'Lindsey',
            'surname'      => 'Cross',
            'email'        => 'lindsey@deviate.test',
            'password'     => 'testpassword',
            'organisation' => 'Test Organisation',
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            "links" => [],
            "data" => [
                "type" => "user",
                "id" => 8,
                "attributes" => [
                    "name" => [
                        "forename" => "Lindsey",
                        "surname" => "Cross",
                        "full_name" => "Lindsey Cross",
                    ],
                    "contact" => [
                        "email" => "lindsey@deviate.test",
                    ],
                    "status" => "active",
                    "dates" => [
                        "created_at" => now()->format('Y-m-d H:i:s'),
                        "updated_at" => now()->format('Y-m-d H:i:s'),
                        "disabled_at" => null,
                    ],
                ],
                "links" => [],
                "relationships" => [
                    "organisation" => [
                        "data" => [
                            "type" => "organisation",
                            "id" => 3,
                        ],
                        "links" => [],
                    ],
                ],
                "meta" => [],
            ],
            "includes" => [
                [
                    "type" => "organisation",
                    "id" => 3,
                    "attributes" => [
                        "name" => [
                            "title" => "Test Organisation",
                            "slug" => "test-organisation",
                        ],
                        "dates" => [
                            "created_at" => now()->format('Y-m-d H:i:s'),
                            "updated_at" => now()->format('Y-m-d H:i:s'),
                        ],
                    ],
                    "links" => [],
                    "relationships" => [],
                    "meta" => [],
                ],
            ],
            "meta" => [],
        ]);
    }
}
