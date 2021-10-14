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
		RoomFactory::createMany(15, function(){ return ['number' => RoomFactory::room(200, 299)]; });
		RoomFactory::createMany(15, function(){ return ['number' => RoomFactory::room(300, 350)]; });
		RoomFactory::createMany(15, function(){ return ['number' => RoomFactory::room(100, 199)]; });
		RoomFactory::createOne(['number'=> 900, 'name' => 'Gold VIP']);
		RoomFactory::createOne(['number'=> 901, 'name' => 'Silver']);
		RoomFactory::createOne(['number'=> 902, 'name' => 'Bronze south']);
		RoomFactory::createOne(['number'=> 903, 'name' => 'Bronze north']);
		
		// TODO This may cause SQL error for UNIQUE key constraint.
		RoomFactory::createOne(['number'=> 201]);
		RoomFactory::createOne(['number'=> 202]);
		RoomFactory::createOne(['number'=> 105]);
	}
	
	public static function byNumber(int $count = 1, int $number = RepositoryProxy::IS_NOT_NULL) : array
	{
		// TODO this will not work if we want more than 2 exact rooms.
		$attributes = ['number' => $number];
		return RoomFactory::randomSet($count, $attributes);
	}
}
