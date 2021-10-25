<?php
namespace App\Test;

use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase as ApiPlatformTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Test\Constraint\EntityShallowMatch;

abstract class ApiTestCase extends ApiPlatformTestCase
{
	protected function createApiClient()
	{
		return new ApiClient(self::createClient());
	}
	
	protected function request(string $method, string $uri, array $headers = [], array $data = [])
	{
		return (new ApiClient(self::createClient()))->request($method, $uri, $headers, $data);
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
	
	protected function assertEntityProperties($entity, $array)
	{
		return false;
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