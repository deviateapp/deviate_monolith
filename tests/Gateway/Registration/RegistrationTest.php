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
            'data' => [
                'user' => [
                    'id' => 8,
                    'name' => [
                        'forename' => 'Lindsey',
                        'surname'  => 'Cross'
                    ],
                    'email' => 'lindsey@deviate.test',
                    'dates' => [
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                        'disabled_at' => null,
                    ],
                ],
                'organisation' => [
                    'id' => 3,
                    'name' => 'Test Organisation',
                    'slug' => 'test-organisation',
                    'dates' => [
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ],
                ],
            ],
        ]);
    }
}
