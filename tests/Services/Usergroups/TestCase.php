<?php

namespace Deviate\Usergroups\Tests\Services;

use Deviate\Usergroups\Client\MembershipClientInterface;
use Deviate\Usergroups\Client\PermissionsClientInterface;
use Deviate\Usergroups\Client\SearchClientInterface;
use Deviate\Usergroups\Client\UsergroupsClientInterface;
use Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /** @var UsergroupsClientInterface */
    protected $usergroupsClient;

    /** @var MembershipClientInterface */
    protected $membershipClient;

    /** @var SearchClientInterface */
    protected $searchClient;

    /** @var PermissionsClientInterface */
    protected $permissionsClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->usergroupsClient  = app(UsergroupsClientInterface::class);
        $this->membershipClient  = app(MembershipClientInterface::class);
        $this->searchClient      = app(SearchClientInterface::class);
        $this->permissionsClient = app(PermissionsClientInterface::class);
    }
}
