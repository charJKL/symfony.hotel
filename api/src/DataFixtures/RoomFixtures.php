<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Room;
use App\Factory\RoomFactory;

class RoomFixtures extends Fixture
{
	public function getDependencies()
	{
		return [FacilitiesFixture::class];
	}

	public function load(ObjectManager $manager)
	{
		RoomFactory::createMany(15, function(){ return ['name' => RoomFactory::room(200, 299)]; });
		RoomFactory::createMany(15, function(){ return ['name' => RoomFactory::room(300, 350)]; });
		RoomFactory::createMany(15, function(){ return ['name' => RoomFactory::room(100, 199)]; });
		RoomFactory::createOne(['name' => 'Gold VIP']);
		RoomFactory::createOne(['name' => 'Silver']);
		RoomFactory::createOne(['name' => 'Bronze south']);
		RoomFactory::createOne(['name' => 'Bronze north']);
	}
}
