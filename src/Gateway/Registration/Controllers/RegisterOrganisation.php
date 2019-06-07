<?php

namespace Deviate\Gateway\Registration\Controllers;

use Deviate\Gateway\Registration\Transformers\RegistrationTransformer;
use Deviate\Organisations\Client\ClientInterface;
use Deviate\Users\Client\CreatesUsersClientInterface;
use Illuminate\Http\Request;
use Deviate\Gateway\Shared\Controllers\Controller;

class RegisterOrganisation extends Controller
{
    private $organisationsClient;
    private $usersClient;

    public function __construct(ClientInterface $organisationsClient, CreatesUsersClientInterface $usersClient)
    {
        $this->organisationsClient = $organisationsClient;
        $this->usersClient         = $usersClient;
    }

    public function __invoke(Request $request)
    {
        $organisation = $this->organisationsClient->createOrganisation([
            'name' => $request->get('organisation'),
        ])->rethrow();

        $user = $this->usersClient->createUser([
            'organisation_id' => $organisation->get('id'),
            'forename'        => $request->get('forename'),
            'surname'         => $request->get('surname'),
            'email'           => $request->get('email'),
            'password'        => $request->get('password'),
        ])->rethrow();

        return $this->document(RegistrationTransformer::class, $user, $organisation);
    }
}
