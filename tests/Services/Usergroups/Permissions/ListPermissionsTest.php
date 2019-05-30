<?php

namespace Deviate\Usergroups\Tests\Services\Permissions;

use Deviate\Usergroups\Tests\Services\TestCase;

class ListPermissionsTest extends TestCase
{
    /** @test */
    public function it_can_return_a_list_of_all_available_permissions_within_their_sections()
    {
        $response = $this->permissionsClient->sections();

        $response->assertSuccessful();

        $this->assertEquals([
            [
                'section'     => 'Test Section',
                'description' => 'This is a test section',
                'permissions' => [
                    [
                        'key'         => 'test.permission',
                        'name'        => 'Test permission',
                        'description' => 'This is a test permission',
                        'is_ownable'  => true,
                    ],
                    [
                        'key'         => 'test.permission.unownable',
                        'name'        => 'Test unownable permission',
                        'description' => 'This is a test unownable permission',
                        'is_ownable'  => false,
                    ],
                ],
            ],
        ], $response->toArray());
    }
}
