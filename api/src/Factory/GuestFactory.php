<?php

namespace App\Factory;

use App\Entity\Guest;
use App\Repository\GuestRepository;
use PhpParser\Node\Expr\FuncCall;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Guest>
 *
 * @method static Guest|Proxy createOne(array $attributes = [])
 * @method static Guest[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Guest|Proxy find(object|array|mixed $criteria)
 * @method static Guest|Proxy findOrCreate(array $attributes)
 * @method static Guest|Proxy first(string $sortedField = 'id')
 * @method static Guest|Proxy last(string $sortedField = 'id')
 * @method static Guest|Proxy random(array $attributes = [])
 * @method static Guest|Proxy randomOrCreate(array $attributes = [])
 * @method static Guest[]|Proxy[] all()
 * @method static Guest[]|Proxy[] findBy(array $attributes)
 * @method static Guest[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Guest[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static GuestRepository|RepositoryProxy repository()
 * @method Guest|Proxy create(array|callable $attributes = [])
 */
final class GuestFactory extends ModelFactory
{
	protected static function getClass() : string
	{
		return Guest::class;
	}
	
	protected function getDefaults(): array
	{
		return [ ];
	}
	
	private function defaultPersonal() : array
	{
		return 
		[
			'name' => self::faker()->firstName(),
			'surname' =>  self::faker()->lastName(),
			'nationality' => self::faker()->country(),
		];
	}
	
	public function withFull() : self
	{
		return $this->withPersonal()->withEmail()->withDocumentId()->withPhone();
	}
	
	public function withPersonal() : self
	{
		return $this->addState($this->defaultPersonal());
	}
	
	public function withEmail() : self
	{
		return $this->addState(['email' => self::faker()->unique()->email()]);
	}
	
	public function withPhone() : self 
	{
		return $this->addState(['phone' => self::faker()->unique()->tollFreePhoneNumber()]);
	}
	
	public function withDocumentId() : self
	{
		return $this->addState(['documentId' => self::faker()->unique()->bothify('???######')]);
	}


}
