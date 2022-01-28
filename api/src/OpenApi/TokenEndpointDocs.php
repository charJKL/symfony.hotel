<?php
namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\Model\Response;
use ArrayObject;

final class TokenEndpointDocs implements OpenApiFactoryInterface
{
	private $decorated;
	
	public function __construct(OpenApiFactoryInterface $decorated)
	{
		$this->decorated = $decorated;
	}
	
	public function __invoke(array $context = []): OpenApi
	{
		$docs = $this->decorated->__invoke($context);
		
		$this->describeTokenEndpoint($docs);
		$this->addTokenSchemas($docs);
		
		return $docs;
	}
	
	private function describeTokenEndpoint(OpenApi &$docs) 
	{
		// Create operation:
		$responseFor200 = new Response(
			description: 'Get JWT token',
			content: new ArrayObject([
				'application/json' => [ 'schema' => [ '$ref' => '#/components/schemas/Token' ] ]
			])
		);
		$requestBody = new RequestBody(
			description: 'Generate new JWT Token',
			content: new ArrayObject([
				'application/json' => [ 'schema' => [ '$ref' => '#/components/schemas/Credentials' ] ]
			])
		);
		
		$operation = new Operation(
			operationId: 'postCredentialsItem',
			summary: 'Get JWT token to login.',
			tags: ['Token'],
			requestBody: $requestBody,
			responses: [ '200' => $responseFor200 ],
		);
		
		$pathItem = new PathItem(
				ref: 'JWT Token',
				post: $operation,
		);
		
		$url = '/api/token';
		$docs->getPaths()->addPath($url, $pathItem);
	}
	
	private function addTokenSchemas(OpenApi &$docs)
	{
		$Token = new ArrayObject([
			'type' => 'object',
			'properties' => [
				'token' => [ 'type' => 'string', 'readOnly' => true ],
				],
		]);
		
		$Credentials = new \ArrayObject([
			'type' => 'object',
			'properties' => [
				'login' => [ 'type' => 'string', 'example' => 'john.doe' ],
				'password' => [ 'type' => 'string', 'example' => 'password' ],
			],
		]);
		
		$schemas = $docs->getComponents()->getSchemas();
		$schemas['Token'] = $Token;
		$schemas['Credentials'] = $Credentials;
	}
}