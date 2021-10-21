<?php
namespace App\Test;

use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase as ApiPlatformTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Test\Constraint\EntityShallowMatch;
use PhpParser\Node\Expr\FuncCall;

abstract class ApiTestCase extends ApiPlatformTestCase
{
	const HTTP_200_OK = Response::HTTP_OK;
	const HTTP_201_HTTP_CREATED = Response::HTTP_CREATED;
	const HTTP_401_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
	const HTTP_404_NOT_FOUND = Response::HTTP_NOT_FOUND;
	const HTTP_405_NOT_ALLOWED = Response::HTTP_METHOD_NOT_ALLOWED;
	
	const HEADER_CONTENT_TYPE = 'content-type';
	const HEADER_ACCEPT = 'accept';
	
	const GET = 'GET';
	const POST = 'POST';
	const POST_JSON = 'POST+JSON';
	const PUT = 'PUT';
	const DELETE = 'DELETE';
	const PATCH = 'PATCH';
	
	protected function request(string $method, string $uri, array $headers = [], array $data = [])
	{
		$options = [];
		$options['headers'] = $headers;
		
		if($method === self::POST)
		{
			$options['body'] = $data;
		}
		if($method === self::POST_JSON)
		{
			$method = self::POST;
			$options['json'] = $data;
		}
		if($method === self::PATCH)
		{
			$options['headers'][self::HEADER_CONTENT_TYPE] = 'application/merge-patch+json';
			$options['json'] = $data;
		}
		
		return static::createClient()->request($method, $uri, $options);
	}
	
	protected function em(string $repository = null)
	{
		if($repository === null) return static::getContainer()->get(EntityManagerInterface::class);
		return static::getContainer()->get(EntityManagerInterface::class)->getRepository($repository);
	}
	
	protected function assertEntityEqualsShallow($first, $second)
	{
		static::assertThat($second, new EntityShallowMatch($first));
	}
	
	/**
	 * Function used to 
	 */ 
	protected function commitAndDie()
	{
		\DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticDriver::commit();
		die;
	}
	
}