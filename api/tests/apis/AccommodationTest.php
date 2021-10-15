<?php
namespace Tests\Apis;

use App\Test\ApiTestCase;
use App\Entity\Accommodation;

class AccommodationTest extends ApiTestCase
{
	public function testOnlyEmailOrPhoneIsRequiredToMakeReservation()
	{
		$json = ['checkInAt'=>'16.10.2021', 'checkOutAt'=>'19.10.2021', 'email'=>'fake@gmail.com', 'roomsAmount'=> 1, 'peopleAmount'=> 2];
		$this->request(self::POST_JSON, '/api/accommodations', [], $json);
		$this->assertResponseStatusCodeSame(self::HTTP_201_HTTP_CREATED);
		
		$accommodations = $this->em(Accommodation::class)->findAll();
		$this->assertCount(1, $accommodations);
		
		$json = ['checkInAt'=>'16.10.2021 12:23', 'checkOutAt'=>'21.10.2021 16:20', 'phone' => '1234-4566-45', 'roomsAmount'=> 2, 'peopleAmount'=> 2];
		$this->request(self::POST_JSON, 'api/accommodations', [], $json);
		$this->assertResponseStatusCodeSame(self::HTTP_201_HTTP_CREATED);
	}
}