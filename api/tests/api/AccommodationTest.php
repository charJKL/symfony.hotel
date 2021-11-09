<?php
namespace Tests\Api;

use App\Test\ApiTestCase;
use App\Test\ApiClientInterface as http;
use App\Factory\AccommodationFactory;
use App\Factory\EmployeeFactory;
use App\Entity\Accommodation;
use App\Entity\Guest;
use App\Factory\GuestFactory;
use App\Factory\RoomFactory;

class AccommodationTest extends ApiTestCase
{
	public function testYouCantDeleteReservation()
	{
		$this->request(http::DELETE, '/api/accommodations/5');
		$this->assertResponseStatusCodeSame(http::HTTP_405_NOT_ALLOWED);
	}
	
	public function testConfirmAccommodationRequireLogin()
	{
		$employee = EmployeeFactory::new()->create();
		$room = RoomFactory::new()->create();
		$accommodation = AccommodationFactory::new()->status(Accommodation::BOOKED)->withRoom($room)->create();
		
		$json = ['status' => Accommodation::CONFIRMED];
		$this->request(http::PATCH, 'api/accommodations/'.$accommodation->getId(), [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_401_UNAUTHORIZED);
		
		$client = self::createApiClient()->logIn($employee);
		$client->request(http::PATCH, 'api/accommodations/'.$accommodation->getId(), [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_200_OK);
		
		// Assert that status was updated:
		$accommodation = $this->em(Accommodation::class)->find($accommodation->getId());
		$this->assertEquals(Accommodation::CONFIRMED, $accommodation->getStatus(), 'Status of accommodation was not updated.');
	}
	
	public function testAssignGuestToAccommodation()
	{
		$employee = EmployeeFactory::new()->create();
		$room = RoomFactory::new()->create();
		$guest = GuestFactory::new()->withEmail()->create();
		$accommodation = AccommodationFactory::new()->status(Accommodation::CONFIRMED)->withRoom($room)->withGuests([$guest])->create();
		
		$guestOne = GuestFactory::new()->withFull()->create();
		
		$client = self::createApiClient()->logIn($employee);
		$client->request(http::PUT, 'api/accommodations/'.$accommodation->getId().'/guests/'.$guestOne->getId(), [], []);
		$this->assertResponseStatusCodeSame(http::HTTP_204_NO_CONTENT);
		
		$accommodation = $this->em(Accommodation::class)->find($accommodation->getId());
		$this->assertCount(2, $accommodation->getGuests());
	}
	
	public function testRemoveGuestFromAccommodation()
	{
		$employee = EmployeeFactory::new()->create();
		$room = RoomFactory::new()->create();
		$guestOne = GuestFactory::new()->withEmail()->create();
		$guestTwo = GuestFactory::new()->withEmail()->create();
		$accommodation = AccommodationFactory::new()->status(Accommodation::CONFIRMED)->withRoom($room)->withGuests([$guestOne, $guestTwo])->create();
		
		$client = self::createApiClient()->logIn($employee);
		$client->request(http::DELETE, 'api/accommodations/'.$accommodation->getId().'/guests/'.$guestOne->getId(), [], []);
		$this->assertResponseStatusCodeSame(http::HTTP_204_NO_CONTENT);
		
		$accommodation = $this->em(Accommodation::class)->find($accommodation->getId());
		$this->assertCount(1, $accommodation->getGuests());
	}
}