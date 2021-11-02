<?php
namespace App\Test;

use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response as PlatformResponse;

interface ApiClientInterface
{
	const HTTP_200_OK = Response::HTTP_OK;
	const HTTP_201_HTTP_CREATED = Response::HTTP_CREATED;
	const HTTP_204_NO_CONTENT = Response::HTTP_NO_CONTENT;
	const HTTP_401_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
	const HTTP_404_NOT_FOUND = Response::HTTP_NOT_FOUND;
	const HTTP_405_NOT_ALLOWED = Response::HTTP_METHOD_NOT_ALLOWED;
	
	const HEADER_CONTENT_TYPE = 'content-type';
	const HEADER_ACCEPT = 'accept';
	
	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';
	const PATCH = 'PATCH';
	
	public function request(string $method, string $uri, array $headers = [], array $data = []) : PlatformResponse;
}