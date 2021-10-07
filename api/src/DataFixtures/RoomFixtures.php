<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Rooms;

class RoomFixtures extends Fixture
{
	private function list()
	{
		return ['201', '202', '203', '204', '301', '302', '303', '100', '101', 'gold', 'silver', 'bronze south', 'bronze north'];
	}
	
	public function load(ObjectManager $manager)
	{
		$rooms = $this->list();
		foreach($rooms as $name)
		{
			$room = new Rooms();
			$room->setName($name);
			$manager->persist($room);
		}

		$manager->flush();
	}
}
