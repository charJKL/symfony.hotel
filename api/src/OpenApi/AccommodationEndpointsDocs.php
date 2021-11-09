<?php
namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\Parameter;
use ApiPlatform\Core\OpenApi\Model\Response;
use PhpParser\Node\Expr\FuncCall;

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
		
		$this->describeAddGuestEndpoint($docs);
		$this->describeRemoveGuestEndpoint($docs);
		
		return $docs;
	}
	
	private function describeAddGuestEndpoint(OpenApi &$docs)
	{
		$url = '/api/accommodations/{accommodation_id}/guests/{guest_id}';
		$path = $docs->getPaths()->getPath($url);
		$original = $path->getPut();
		
		// Create operation description:
		$operation = new Operation('add_guests');
		$operationResponses = [];
		$operationResponses[204] = new Response("Relation added.", null, null, null);
		$operationResponses[404] = new Response("Relation not found", null, null, null);
		$operation = $operation->withResponses($operationResponses);
		$operation = $operation->withTags($original->getTags());
		$operation = $operation->withSummary('Assign Guest to Accommodation');
		$operation = $operation->withDescription('Assign Guest to Accommodation');
		$operationAccommodationId = new Parameter('accommodation_id', 'path', 'Accommodation id.', true);
		$operationGuestId = new Parameter('guest_id', 'path', 'Guest id.', true);
		$operation = $operation->withParameters([$operationAccommodationId, $operationGuestId]);
		
		// Override PUT operation:
		$path = $path->withPut($operation);
		$docs->getPaths()->addPath($url, $path);
	}
	
	public function describeRemoveGuestEndpoint(OpenApi &$docs)
	{
		$url = '/api/accommodations/{accommodation_id}/guests/{guest_id}';
		$path = $docs->getPaths()->getPath($url);
		$original = $path->getDelete();
		
		// Create operation description:
		$operation = new Operation('remove_guests');
		$operationResponses = [];
		$operationResponses[204] = new Response("Relation removed.", null, null, null);
		$operationResponses[404] = new Response("Relation not found", null, null, null);
		$operation = $operation->withResponses($operationResponses);
		$operation = $operation->withTags($original->getTags());
		$operation = $operation->withSummary('Remove Guest from Accommodation');
		$operation = $operation->withDescription('Remove Guest from Accommodation');
		$operationAccommodationId = new Parameter('accommodation_id', 'path', 'Accommodation id.', true);
		$operationGuestId = new Parameter('guest_id', 'path', 'Guest id.', true);
		$operation = $operation->withParameters([$operationAccommodationId, $operationGuestId]);
		
		// Override DELETE operation:
		$path = $path->withDelete($operation);
		$docs->getPaths()->addPath($url, $path);
	}
}