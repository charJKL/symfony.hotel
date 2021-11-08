<?php

namespace App\DataFixtures;

use App\Entity\Accommodation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\AccommodationFactory;
use App\DataFixtures\RoomFixtures;
use App\DataFixtures\GuestFixtures;


class AccomodationFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [RoomFixtures::class, GuestFixtures::class];
	}

	public function load(ObjectManager $manager): void
	{
		AccommodationFactory::new()->status(Accommodation::BOOKED)->forDays('26.10.2021', 3)->withRooms(RoomFixtures::byNumber(201))->withGuests(GuestFixtures::byPhone(1))->create();
		AccommodationFactory::new()->status(Accommodation::BOOKED)->forDays('+1 day', 5)->withRooms(RoomFixtures::byNumber(901))->withGuests(GuestFixtures::byPhone(3))->create();
		AccommodationFactory::new()->status(Accommodation::CHECKED_IN)->forPeriod('-1 days', '+3 days')->withRooms(RoomFixtures::byNumber(202))->withGuests(GuestFixtures::byPersonal(3))->create();
		AccommodationFactory::new()->status(Accommodation::CHECKED_IN)->forPeriod('-2 days', '+4 days')->withRooms(RoomFixtures::byNumber(205, 206, 207, 208))->withGuests(GuestFixtures::byPersonal(2))->create();
		AccommodationFactory::new()->status(Accommodation::CHECKED_IN)->forPeriod('-1 days', '+7 days')->withRooms(RoomFixtures::byNumber(204))->withGuests(GuestFixtures::byPersonal(1))->create();
		AccommodationFactory::new()->status(Accommodation::CHECKED_OUT)->forPeriod('-7 days', 'now')->withRooms(RoomFixtures::byNumber(105))->withGuests(GuestFixtures::byPersonal())->create();
	}
	
	public static function byStatus($count, $status): array
	{
		$attributes = ['status' => $status];
		return AccommodationFactory::randomSet($count, $attributes);
	}
}
