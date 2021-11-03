<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Employee;
use App\Factory\EmployeeFactory;

class EmployeeFixtures extends Fixture
{
	public function load(ObjectManager $manager): void
	{
		EmployeeFactory::new()->withUuid('admin')->withPlainPassword('password1')->withRoles(['ROLE_MANAGER'])->create();
		EmployeeFactory::new()->withUuid('annie')->create();
		EmployeeFactory::new()->withUuid('thomas.black')->create();
	}
}