<?php
namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Factory\RoomFactory;
use LogicException;
use RuntimeException;

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
		
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(105)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(201)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(202)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(203)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(204)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(205)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(206)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(207)->create();
		RoomFactory::new()->withFacilities(FacilitiesFixture::byCount(1,5))->withNumber(208)->create();
	}
	
	public static function get($count = 1)
	{
		return RoomFactory::randomSet($count);
	}
	
	public static function byNumber($number)
	{
		try
		{
			return RoomFactory::find(['number' => $number]);
		}catch(RuntimeException $e)
		{
			throw new LogicException("Room with number `$number` wasn't created.");
		}
	}
}

