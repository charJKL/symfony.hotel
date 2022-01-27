<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\OfferFactory;

class OfferFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		OfferFactory::new()->withName("Sunny winter")->withImage("/offers/offer-id-1.png")->create();
		OfferFactory::new()->withName("Frosty spring")->withImage("/offers/offer-id-2.png")->create();
		OfferFactory::new()->withName("Cold summer")->withImage("/offers/offer-id-3.png")->create();
	}
}
