<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Facility;

class FacilitiesFixture extends Fixture
{
	private function values()
	{
		return [
			["name" => "one bed", "description" => "Room contains one bed."],
			["name" => "double bed", "description" => "Room contains one big bed."],
			["name" => "two bed", "description" => "Room contains two separate beds."],
			["name" => "bath", "description" => "Room contains separate bath."],
			["name" => "tv", "description" => "You can watch tv."],
			["name" => "wi-fi", "description" => "You have access to WI-FI."],
			["name" => "sea view", "description" => "You can see sea from window."],
			["name" => "air conditioning", "description" => "Room contains air conditioning"],
		];
	}
	
	public function load(ObjectManager $manager): void
	{
		$values = $this->values();
		foreach($values as $value)
		{
			$facility = new Facility();
			$facility->setName($value['name']);
			$facility->setDescription($value['description']);
			$manager->persist($facility);
			$this->addReference($value['name'], $facility);
		}
		
		$manager->flush();
	}
}
