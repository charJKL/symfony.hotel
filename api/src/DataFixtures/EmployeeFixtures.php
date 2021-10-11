<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Employee;

class EmployeeFixtures extends Fixture
{
	private $hasher = null;
	
	public function __construct(UserPasswordHasherInterface $hasher)
	{
		$this->hasher = $hasher;
	}
	
	public function load(ObjectManager $manager): void
	{
		$employee = new Employee();
			$employee->setUuid('admin');
			$password = $this->hasher->hashPassword($employee, 'password1');
			$employee->setPassword($password);
			
		$manager->persist($employee);
		$manager->flush();
	}
}