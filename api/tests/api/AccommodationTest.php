<?php
namespace Tests\Api;

use App\DataFixtures\AccomodationFixtures;
use App\Test\ApiTestCase;
use App\Entity\Accommodation;
use App\Entity\Guest;
use App\Factory\AccommodationFactory;

class AccommodationTest extends ApiTestCase
{
	public function emailOrPhoneProvider() : iterable
	{
		yield [ ['checkInAt'=>'16.10.2021', 'checkOutAt'=>'19.10.2021 12:23', 'roomsAmount'=> 1, 'peopleAmount'=> 2, 'guests'=>[['email'=>'fake@gmail.com']]] ];
		yield [ ['checkInAt'=>'16.10.2021', 'checkOutAt'=>'21.10.2021 16:20', 'roomsAmount'=> 2, 'peopleAmount'=> 2, 'guests'=>[['phone'=>'1234-4566-45']]] ];
	}
	
	/**
	 * @dataProvider emailOrPhoneProvider
	 */
	public function testOnlyEmailOrPhoneIsRequiredToMakeReservation(array $json)
	{
		$this->request(self::POST_JSON, '/api/accommodations', [], $json);
		$this->assertResponseStatusCodeSame(self::HTTP_201_HTTP_CREATED);
		
		// One accommodation record should be added:
		$accommodations = $this->em(Accommodation::class)->findAll();
		$this->assertCount(1, $accommodations);
		
		// Inital status of added accomodation should be Accommodation::BOOKED;
		$accommodation = $this->em(Accommodation::class)->findAll()[0];
		$this->assertEquals($accommodation->getStatus(), Accommodation::BOOKED);
		
		// Check if corresponding `Guest` was created:
		$query = $this->em(Guest::class)->createQueryBuilder('g');
		if(isset($json['guests'][0]['email'])) $query->orWhere('g.email = :email')->setParameter('email', $json['guests'][0]['email']);
		if(isset($json['guests'][0]['phone'])) $query->orWhere('g.phone = :phone')->setParameter('phone', $json['guests'][0]['phone']);
		$guest = $query->getQuery()->getOneOrNullResult();
		$this->assertNotNull($guest);
		$this->assertEntityEqualsShallow($accommodation->getGuests()[0], $guest);
	}
	
	public function testYouCantDeleteReservation()
	{
		$this->request(self::DELETE, '/api/accommodations/5');
		$this->assertResponseStatusCodeSame(self::HTTP_405_NOT_ALLOWED);
	}
	
	public function testConfirmAccommodationRequireLogin()
	{
		$accommodation = AccommodationFactory::new()->status(Accommodation::BOOKED)->create();

		$json = ['status' => Accommodation::CONFIRMED];
		$this->request(self::PATCH, 'api/accommodations/'.$accommodation->getId(), [], $json);
		$this->assertResponseStatusCodeSame(self::HTTP_401_UNAUTHORIZED);

		$this->request(self::PATCH, 'api/accommodations/'.$accommodation->getId(), [], $json);
		$this->assertResponseStatusCodeSame(self::HTTP_201_HTTP_CREATED);
		
		// Assert that status was updated:
		$accommodation = $this->em(Accommodation::class)->find($accommodation->getId());
		$this->assertEquals(Accommodation::CONFIRMED, $accommodation->getStatus(), 'Status of accommodation was not updated.');
	}
}