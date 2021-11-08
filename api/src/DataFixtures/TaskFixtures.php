<?php
namespace App\DataFixtures;


use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\RoomFixtures;
use App\DataFixtures\GuestFixtures;
use App\Entity\Service;
use App\Factory\TaskFactory;
use App\DataFixtures\AccomodationFixtures;
use App\Entity\Accommodation;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [AccomodationFixtures::class, RoomFixtures::class, ServiceFixtures::class];
	}

	public function load(ObjectManager $manager): void
	{
		$accommodation = AccomodationFixtures::byStatus(1, Accommodation::CHECKED_IN)[0];
		TaskFactory::new()->withService(ServiceFixtures::byCount(1, 1)[0])->withRoom($accommodation->getRooms()[0])->create();
		TaskFactory::new()->withService(ServiceFixtures::byCount(1, 1)[0])->withRoom($accommodation->getRooms()[0])->create();
		
		$accommodation = AccomodationFixtures::byStatus(1, Accommodation::CHECKED_IN)[0];
		TaskFactory::new()->withService(ServiceFixtures::byCount(1, 1)[0])->withRoom($accommodation->getRooms()[0])->create();
		TaskFactory::new()->withService(ServiceFixtures::byCount(1, 1)[0])->withRoom($accommodation->getRooms()[0])->create();
	}
}
