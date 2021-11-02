<?php
namespace App\Test;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response as PlatformResponse;
use Zenstruck\Foundry\Proxy as FoundryProxy;

class ApiClient implements ApiClientInterface
{
	private $client;
	
	public function __construct(Client $client)
	{
		$this->client = $client;
	}
	
	public function request(string $method, string $uri, array $headers = [], array $data = []) : PlatformResponse
	{
		$options = [];
		$options['headers'] = $headers;
		
		if($method === self::POST)
		{
			$options['json'] = $data;
		}
		if($method === self::PATCH)
		{
			$options['headers'][self::HEADER_CONTENT_TYPE] = 'application/merge-patch+json';
			$options['json'] = $data;
		}
		if($method === self::PUT)
		{
			$options['headers'][self::HEADER_CONTENT_TYPE] = 'application/json';
		}
		
		return $this->client->request($method, $uri, $options);
	}
	
	public function logIn(object $user, string $firewallContext = 'main') : self
	{
		$user = ($user instanceof FoundryProxy) ? $user->object() : $user; // TODO remove hard coupling to Zenstruck\Foundry\Proxy bundle.
		$this->client->getKernelBrowser()->loginUser($user, $firewallContext);
		return $this;
	}
}

