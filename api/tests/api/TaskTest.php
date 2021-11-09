<?php
namespace Tests\Api;

use App\Factory\AccommodationFactory;
use App\Factory\EmployeeFactory;
use App\Factory\GuestFactory;
use App\Test\ApiTestCase;
use App\Test\ApiClientInterface as http;
use App\Entity\Accommodation;
use App\Factory\RoomFactory;
use App\Factory\ServiceFactory;
use App\Entity\Task;

class TaskTest extends ApiTestCase
{
	public function testOnlyConfirmedGuestCanCreateTasks()
	{
		$guest = GuestFactory::new()->withFull()->create();
		$service = ServiceFactory::new()->create();
		$room = RoomFactory::new()->create();
		$accommodation = AccommodationFactory::new()->withStatus(Accommodation::CHECKED_IN)->withGuests([$guest])->withRooms($room)->create();
		
		$json = ['service' => self::getIri($service), 'room' => self::getIri($room)];
		
		$client = self::createApiClient();
		$client->request(http::POST, 'api/tasks', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_401_UNAUTHORIZED);
		
		$client = self::createApiClient()->logIn($guest);
		$response = $client->request(http::POST, 'api/tasks', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_201_HTTP_CREATED);
	}
}