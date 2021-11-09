<?php

namespace App\DataFixtures;

use App\Entity\Accommodation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\AccommodationFactory;
use App\DataFixtures\RoomFixtures;
use App\DataFixtures\GuestFixtures;
use App\Entity\Reservation;
use App\Factory\ReservationFactory;

class ReservationFixtures extends Fixture 
{
	public function load(ObjectManager $manager): void
	{
		ReservationFactory::new()->create();
		ReservationFactory::new()->create();
		ReservationFactory::new()->create();
		ReservationFactory::new()->create();
		ReservationFactory::new()->create();
	}
}
