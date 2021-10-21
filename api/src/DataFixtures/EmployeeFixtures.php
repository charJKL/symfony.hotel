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
		EmployeeFactory::new()->uuid('admin')->password('password1')->withRoles(['ROLE_MANAGER'])->create();
		EmployeeFactory::new()->uuid('annie')->create();
		EmployeeFactory::new()->uuid('thomas.black')->create();
	}
}