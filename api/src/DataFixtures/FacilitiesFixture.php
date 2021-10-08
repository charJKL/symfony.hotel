<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Facility;
use App\Factory\FacilityFactory;

class FacilitiesFixture extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		FacilityFactory::createMany(20);
	}
}
