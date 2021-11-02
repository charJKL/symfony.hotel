<?php
namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\Parameter;

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
		
		$addGuestOperationUrl = '/api/accommodations/{id}/guests/{guest_id}';
			$addGuestPath = $docs->getPaths()->getPath($addGuestOperationUrl);
			$addGuestOperationOriginal = $addGuestPath->getPut();
			$addGuestOperationParameters = $addGuestOperationOriginal->getParameters();
			$addGuestOperation = new Operation('add_guest');
			$addGuestOperation = $addGuestOperation->withResponses($addGuestOperationOriginal->getResponses());
			$addGuestOperation = $addGuestOperation->withTags($addGuestOperationOriginal->getTags());
			$addGuestOperation = $addGuestOperation->withSummary('Assosiate guest with accommodation');
			$addGuestOperation = $addGuestOperation->withDescription('Assign guest to accommodation');
			$addGuestOperationGuestId = new Parameter('guest_id', 'path', 'Guest id.', true);
			$addGuestOperation = $addGuestOperation->withParameters(array_merge($addGuestOperationParameters,[$addGuestOperationGuestId]));
			
			$addGuestPath = $addGuestPath->withPut($addGuestOperation);
			$docs->getPaths()->addPath($addGuestOperationUrl, $addGuestPath);
		
		return $docs;
	}
}