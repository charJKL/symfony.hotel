<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\ServiceFactory;

class ServiceFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		ServiceFactory::createMany(5);
	}
	
	public static function byCount(int $from, int $to) : array
	{
		return ServiceFactory::randomRange($from, $to);
	}
}
