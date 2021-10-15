<?php
namespace App\Test;

use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase as ApiPlatformTestCase;

abstract class ApiTestCase extends ApiPlatformTestCase
{
	const HTTP_200_OK = Response::HTTP_OK;
	const HTTP_201_HTTP_CREATED = Response::HTTP_CREATED;
	
	const HEADER_CONTENT_TYPE = 'content-type';
	const HEADER_ACCEPT = 'accept';
	
	const POST = 'POST';
	const POST_JSON = 'POST+JSON';
	const GET = 'GET';
	
	protected function request(string $method, string $uri, array $headers = [], array $data = [])
	{
		if($method === self::POST_JSON) return static::createClient()->request(self::POST, $uri, $headers + ['json' => $data]);
		if($method === self::POST) return static::createClient()->request(self::POST, $uri, $headers + ['body' => $data]);
		return static::createClient()->request($method, $uri, $headers + $data);
	}
}