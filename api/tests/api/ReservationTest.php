<?php
namespace Tests\Api;

use App\Test\ApiTestCase;
use App\Test\ApiClientInterface as http;
use App\Entity\Reservation;

class ReservationTest extends ApiTestCase
{
	public function emailOrPhoneProvider() : iterable
	{
		yield [ ['checkInAt'=>'16.10.2021', 'checkOutAt'=>'19.10.2021 12:23', 'roomsAmount'=> 1, 'peopleAmount'=> 2, 'contact'=>'fake@email.com'] ];
		yield [ ['checkInAt'=>'16.10.2021', 'checkOutAt'=>'21.10.2021 16:20', 'roomsAmount'=> 2, 'peopleAmount'=> 2, 'contact'=>'-48 550 684 456'] ];
	}
	
	/**
	 * @dataProvider emailOrPhoneProvider
	 */
	public function testOnlyEmailOrPhoneIsRequiredToMakeReservation(array $json)
	{
		$this->request(http::POST, '/api/reservations', [], $json);
		$this->assertResponseStatusCodeSame(http::HTTP_201_HTTP_CREATED);
		
		// One accommodation record should be added:
		$accommodations = $this->em(Reservation::class)->findAll();
		$this->assertCount(1, $accommodations);
		
		// Inital status of added accomodation should be Reservation::BOOKED;
		$accommodation = $this->em(Reservation::class)->findAll()[0];
		$this->assertEquals($accommodation->getStatus(), Reservation::BOOKED);
	}
}