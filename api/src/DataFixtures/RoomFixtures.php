<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Factory\RoomFactory;


class RoomFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [FacilitiesFixture::class];
	}

	public function load(ObjectManager $manager)
	{
		RoomFactory::createMany(15, function(){ return ['number' => RoomFactory::room(200, 299)]; });
		RoomFactory::createMany(15, function(){ return ['number' => RoomFactory::room(300, 350)]; });
		RoomFactory::createMany(15, function(){ return ['number' => RoomFactory::room(100, 199)]; });
		RoomFactory::createOne(['number'=> 900, 'name' => 'Gold VIP']);
		RoomFactory::createOne(['number'=> 901, 'name' => 'Silver']);
		RoomFactory::createOne(['number'=> 902, 'name' => 'Bronze south']);
		RoomFactory::createOne(['number'=> 903, 'name' => 'Bronze north']);
	}
	
	public static function byNumber(int $number)
	{
		return RoomFactory::findBy(['number' => $number]);
	}
}
