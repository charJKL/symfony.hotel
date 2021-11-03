<?php
namespace Tests\Api;

use App\Test\ApiTestCase;
use App\Test\ApiClientInterface as http;
use App\Factory\EmployeeFactory;
use App\Factory\GuestFactory;

class LoginAuthenticatonTest extends ApiTestCase
{
	public function testEmployeeCanLogIn()
	{
		self::bootKernel();
		$employee = EmployeeFactory::new()->withUuid('mark.admin')->withPlainPassword('admin-super-password')->create();
		
		$json = ['login' => 'mark.admin', 'password' => 'admin-super-password'];
		
		$this->request(http::POST, '/login', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
	}
	
	public function testGuestCanLogInByEmail()
	{
		self::bootKernel();
		$guest = GuestFactory::new()->withEmail('fake@email.com')->withPlainPassword('secretPassword')->create();

		$json = ['login' => 'fake@email.com', 'password' => 'secretPassword'];
		
		$this->request(http::POST, '/login', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
	}
	
	/*
	public function testGuestCanLogInByPhone()
	{
		self::bootKernel();
		$guest = GuestFactory::new()->withPhone('00-54566-4566')->withPassword('super-secret-password')->create();
		
		$json = ['login'=> $guest->getPhone(), 'password' => 'super-secret-password'];
		
		var_dump($json);
		$this->request(http::POST, '/login', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
	}
	*/
}