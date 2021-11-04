<?php
namespace Tests\Api;

use App\Entity\Accommodation;
use App\Factory\AccommodationFactory;
use App\Test\ApiTestCase;
use App\Test\ApiClientInterface as http;
use App\Factory\EmployeeFactory;
use App\Factory\GuestFactory;
use App\Factory\RoomFactory;

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

		$json = ['identifier' => 'fake@email.com', 'password' => 'secretPassword'];
		
		$this->request(http::POST, '/api/guests/login', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
	}
	
	public function testGuestCanLogInByPhone()
	{
		self::bootKernel();
		$guest = GuestFactory::new()->withPhone('000-123-555')->withPlainPassword('super-secret-password')->create();
		
		$json = ['identifier'=> '000-123-555', 'password' => 'super-secret-password'];
		
		$this->request(http::POST, '/api/guests/login', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
	}
	
	public function testGuestCanLogInByRoom()
	{
		self::bootKernel();
		$room = RoomFactory::new()->withNumber(201)->create();
		$guestOne = GuestFactory::new()->withFull()->withPlainPassword('password123')->create();
		$guestTwo = GuestFactory::new()->withFull()->withPlainPassword('diffrent-password')->create();
		$accommodation = AccommodationFactory::new()->status(Accommodation::CHECKED_IN)->withRooms([$room])->withGuests([$guestOne, $guestTwo])->create();
		
		$json = ['identifier'=> '201', 'password' => 'password123'];
		$this->request(http::POST, '/api/guests/login', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
		$user = self::getContainer()->get('security.token_storage')->getToken()->getUser();
		$this->assertEquals($guestOne->getId(), $user->getId());

		$json = ['identifier'=> '201', 'password' => 'diffrent-password'];
		$this->request(http::POST, '/api/guests/login', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
		$user = self::getContainer()->get('security.token_storage')->getToken()->getUser();
		$this->assertEquals($guestTwo->getId(), $user->getId());
	}
}
