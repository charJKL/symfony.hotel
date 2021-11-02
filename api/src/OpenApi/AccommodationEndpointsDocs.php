<?php
namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\Parameter;
use ApiPlatform\Core\OpenApi\Model\Response;

class AccommodationEndpointsDocs implements OpenApiFactoryInterface
{
	private $decorated;
	
	public function __construct(OpenApiFactoryInterface $decorated)
	{
		$this->decorated = $decorated;
	}
	
	public function __invoke(array $context = []): OpenApi
	{
		$docs = $this->decorated->__invoke($context);
		
		$addGuestOperationUrl = '/api/accommodations/{accommodation_id}/guests/{guest_id}';
			$addGuestPath = $docs->getPaths()->getPath($addGuestOperationUrl);
			$addGuestOperationOriginal = $addGuestPath->getPut();
			$addGuestOperation = new Operation('add_guest');
			$addGuestOperationResponses = [];
			$addGuestOperationResponses[204] = new Response("Relation added.", null, null, null);
			$addGuestOperationResponses[404] = new Response("Resource not found", null, null, null);
			$addGuestOperation = $addGuestOperation->withResponses($addGuestOperationResponses);
			$addGuestOperation = $addGuestOperation->withTags($addGuestOperationOriginal->getTags());
			$addGuestOperation = $addGuestOperation->withSummary('Assign Guest to Accommodation');
			$addGuestOperation = $addGuestOperation->withDescription('Assign Guest to Accommodation');
			$addGuestOperationAccommodationId = new Parameter('accommodation_id', 'path', 'Accommodation id.', true);
			$addGuestOperationGuestId = new Parameter('guest_id', 'path', 'Guest id.', true);
			$addGuestOperation = $addGuestOperation->withParameters([$addGuestOperationAccommodationId, $addGuestOperationGuestId]);
			

			
			$addGuestPath = $addGuestPath->withPut($addGuestOperation);
			$docs->getPaths()->addPath($addGuestOperationUrl, $addGuestPath);
		
		return $docs;
	}
}