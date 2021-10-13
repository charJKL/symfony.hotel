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
		AccommodationFactory::new()->status(Accommodation::BOOKED)->forDays('26.10.2021', 3)->forRooms(RoomFixtures::byNumber(201))->withGuests(GuestFixtures::byPhone())->create();
		AccommodationFactory::new()->status(Accommodation::BOOKED)->forDays('+1 day', 5)->forRooms(RoomFixtures::byNumber(201))->withGuests(GuestFixtures::byPhone())->create();
		AccommodationFactory::new()->status(Accommodation::CHECKED_IN)->forPeriod('+3 days', '+7 days')->forRooms(RoomFixtures::byNumber(202))->withGuests(GuestFixtures::byPersonal())->create();
		AccommodationFactory::new()->status(Accommodation::CHECKED_OUT)->forPeriod('-7 days', 'now')->forRooms(RoomFixtures::byNumber(105))->withGuests(GuestFixtures::byPersonal())->create();
	}
}
