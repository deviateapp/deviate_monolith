<?php

namespace Deviate\Gateway;

use Deviate\Gateway\Shared\JsonObjects\ResourceFactory;
use Deviate\Gateway\Shared\JsonObjects\Schemas\OrganisationSchema;
use Deviate\Gateway\Shared\JsonObjects\Schemas\UserSchema;
use Illuminate\Support\ServiceProvider;

class GatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();

        ResourceFactory::registerSchemas([
            'user'         => UserSchema::class,
            'organisation' => OrganisationSchema::class,
        ]);
    }
}
