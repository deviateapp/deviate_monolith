<?php

namespace Deviate\Gateway\Registration\Controllers;

use Deviate\Organisations\Client\ClientInterface;
use Deviate\Users\Client\CreatesUsersClientInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterOrganisation extends Controller
{
    private $organisationsClient;
    private $usersClient;

    public function __construct(ClientInterface $organisationsClient, CreatesUsersClientInterface $usersClient)
    {
        $this->organisationsClient = $organisationsClient;
        $this->usersClient         = $usersClient;
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
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

        return [
            'data' => [
                'user'         => [
                    'id'    => $user->get('id'),
                    'name'  => [
                        'forename' => $user->get('forename'),
                        'surname'  => $user->get('surname'),
                    ],
                    'email' => $user->get('email'),
                    'dates' => [
                        'created_at'  => $user->get('created_at'),
                        'updated_at'  => $user->get('updated_at'),
                        'disabled_at' => $user->get('disabled_at'),
                    ],
                ],
                'organisation' => [
                    'id'    => $organisation->get('id'),
                    'name'  => $organisation->get('name'),
                    'slug'  => $organisation->get('slug'),
                    'dates' => [
                        'created_at' => $organisation->get('created_at'),
                        'updated_at' => $organisation->get('updated_at'),
                    ],
                ],
            ],
        ];
    }
}
