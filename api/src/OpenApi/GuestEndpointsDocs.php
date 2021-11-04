<?php
namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\Model\Response;
use ArrayObject;

class GuestEndpointsDocs implements OpenApiFactoryInterface
{
	private $decorated;
	
	public function __construct(OpenApiFactoryInterface $decorated)
	{
		$this->decorated = $decorated;
	}
	
	public function __invoke(array $context = []): OpenApi
	{
		$docs = $this->decorated->__invoke($context);
		
		$this->describeGuestLoginEndpoint($docs);
		
		return $docs;
	}
	
	private function describeGuestLoginEndpoint(OpenApi &$docs)
	{
		$url = '/api/guests/login';
		$path = $docs->getPaths()->getPath($url);
		$original = $path->getPost();
		
		// Create operation description:
		$operation = new Operation('login');
		$operationResponses = [];
		$operationResponses[200] = new Response("Authorized.", null, null, null);
		$operationResponses[401] = new Response("Unauthorized", null, null, null); // TODO is not true that this doesn't return anything.
		$operation = $operation->withResponses($operationResponses);
		$operation = $operation->withTags($original->getTags());
		$operation = $operation->withSummary('Login Guest');
		$operation = $operation->withDescription('Login guest');
		$operation = $operation->withRequestBody($original->getRequestBody());

		// Override PUT operation:
		$path = $path->withPost($operation);
		$docs->getPaths()->addPath($url, $path);
	}
}