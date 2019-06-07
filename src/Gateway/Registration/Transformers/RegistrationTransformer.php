<?php

namespace Deviate\Gateway\Registration\Transformers;

use Deviate\Gateway\Shared\JsonObjects\Document;
use Deviate\Gateway\Shared\JsonObjects\Relationships\SingularRelationship;
use Deviate\Gateway\Shared\JsonObjects\ResourceFactory;
use Deviate\Gateway\Shared\JsonObjects\ResourceInterface;
use Deviate\Shared\Responses\Clients\ApiResponseInterface;

class RegistrationTransformer
{
    private $user;
    private $organisation;

    public function __construct(ApiResponseInterface $user, ApiResponseInterface $organisation)
    {
        $this->user = $user;
        $this->organisation = $organisation;
    }

    public function transform()
    {
        /**
         * @var ResourceInterface $userResource
         * @var ResourceInterface $organisationResource
         */
        [$userResource, $organisationResource] = ResourceFactory::make([
            'user'         => $this->user,
            'organisation' => $this->organisation,
        ]);

        $document = new Document($userResource);
        $document->addInclude($organisationResource);

        return $document;
    }
}
