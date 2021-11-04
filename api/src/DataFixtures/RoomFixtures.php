<?php
namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Zenstruck\Foundry\RepositoryProxy;
use App\Factory\RoomFactory;

class RoomFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [FacilitiesFixture::class];
	}

	public function load(ObjectManager $manager)
	{
		for($x = 0; $x < 15; $x++) RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(210, 299)->create();
		for($x = 0; $x < 15; $x++) RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(300, 350)->create();
		for($x = 0; $x < 15; $x++) RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(110, 199)->create();
		
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(900)->withName('Gold VIP')->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(901)->withName('Silver')->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(902)->withName('Bronze south')->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(903)->withName('Bronze north')->create();
		
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(201)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(202)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(105)->create();
	}
	
	public static function byNumber(int $count = 1, int $number = RepositoryProxy::IS_NOT_NULL) : array
	{
		// TODO this will not work if we want more than 2 exact rooms.
		$attributes = ['number' => $number];
		return RoomFactory::randomSet($count, $attributes);
	}
}
