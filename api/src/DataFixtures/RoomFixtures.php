<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Room;

class RoomFixtures extends Fixture
{
	public function getDependencies()
	{
		return [FacilitiesFixture::class];
	}
	
	private function list()
	{
		return ['201', '202', '203', '204', '301', '302', '303', '100', '101', 'gold', 'silver', 'bronze south', 'bronze north'];
	}
	
	public function load(ObjectManager $manager)
	{
		$rooms = $this->list();
		foreach($rooms as $name)
		{
			$room = new Room();
			$room->setName($name);
			$room->addFacility($this->getReference('one bed'));
			$manager->persist($room);
		}

		$manager->flush();
	}
}
