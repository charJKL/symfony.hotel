<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\GuestFactory;

class GuestFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		GuestFactory::new()->withFull()->create();
		GuestFactory::new()->withFull()->create();
		GuestFactory::new()->withFull()->create();
		GuestFactory::new()->withFull()->create();
		GuestFactory::new()->withFull()->create();
		
		GuestFactory::new()->withEmail()->create();
		GuestFactory::new()->withEmail()->create();
		
		GuestFactory::new()->withPhone()->create();
		GuestFactory::new()->withPhone()->create();
		
		GuestFactory::new()->withPersonal()->withDocumentId()->withEmail()->create();
		GuestFactory::new()->withPersonal()->withDocumentId()->withPhone()->create();
	}
	
	public static function byPhone()
	{
		return GuestFactory::random();
	}
	
	public static function byPersonal()
	{
		return GuestFactory::random();
	}
}