<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Zenstruck\Foundry\RepositoryProxy;
use App\Factory\GuestFactory;
use RuntimeException;

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
	
	public static function byPhone($count = 1, $phone = RepositoryProxy::IS_NOT_NULL) : array
	{
		$attributes = ['phone' => $phone];
		return GuestFactory::randomSet($count, $attributes);
	}
	
	public static function byPersonal($count = 1): array
	{
		$attributes = ['name'=> RepositoryProxy::IS_NOT_NULL, 'surname'=> RepositoryProxy::IS_NOT_NULL, 'nationality' => RepositoryProxy::IS_NOT_NULL];
		return GuestFactory::randomSet($count, $attributes);
	}
}