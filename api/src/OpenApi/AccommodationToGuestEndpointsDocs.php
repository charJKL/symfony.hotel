<?php
namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\Parameter;

class AccommodationToGuestEndpointsDocs implements OpenApiFactoryInterface
{
	private $decorated;
	
	public function __construct(OpenApiFactoryInterface $decorated)
	{
		$this->decorated = $decorated;
	}
	
	public function __invoke(array $context = []): OpenApi
	{
		$docs = $this->decorated->__invoke($context);
		
		$putOperationUrl = '/api/accommodation/{accommodation_id}/guest/{guest_id}';
			$putOperationPath = $docs->getPaths()->getPath($putOperationUrl);
			$putOperationOriginal = $putOperationPath->getPut();
			$putOperation = new Operation('put');
			$putOperation = $putOperation->withResponses($putOperationOriginal->getResponses());
			$putOperation = $putOperation->withTags($putOperationOriginal->getTags());
			$putOperation = $putOperation->withSummary('Assign guest to accommodation.');
			$putOperation = $putOperation->withDescription('Assign guest to accommodation.');
			$putOperationAccommodationId = new Parameter('accommodation_id', 'path', 'Accommodaction id.', true);
			$putOperationGuestId = new Parameter('guest_id', 'path', 'Guest id.', true);
			$putOperation = $putOperation->withParameters([$putOperationAccommodationId, $putOperationGuestId]);
			$putOperationPath = $putOperationPath->withPut($putOperation);
			$docs->getPaths()->addPath($putOperationUrl, $putOperationPath);

		$paths = $docs->getPaths();
		foreach($paths as $url => $path)
		{
			
		}

		return $docs;
	}
}