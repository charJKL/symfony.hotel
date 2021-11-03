<?php

namespace App\Factory;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use App\Repository\GuestRepository;
use App\Entity\Guest;

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
	private static $hasher = null;
	
	public function __construct(UserPasswordHasherInterface $hasher)
	{
		parent::__construct();
		self::$hasher = $hasher;
	}
	
	protected static function getClass() : string
	{
		return Guest::class;
	}
	
	protected function initialize() : self
	{
		return $this->afterInstantiate([self::class, 'afterInstantiateGuest']);
	}
	
	public static function afterInstantiateGuest(Guest $guest, array $attributes) : void
	{
		$password = $guest->getPlainPassword() ?? 'password';
		$guest->setPassword(self::$hasher->hashPassword($guest, $password));
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
	
	public function withEmail(string $email = null) : self
	{
		return $this->addState(['email' => $email ?? self::faker()->unique()->email()]);
	}
	
	public function withPhone(string $phone = null) : self 
	{
		return $this->addState(['phone' => $phone ?? self::faker()->unique()->tollFreePhoneNumber()]);
	}
	
	public function withDocumentId(string $documentId = null) : self
	{
		return $this->addState(['documentId' => $documentId ?? self::faker()->unique()->bothify('???######')]);
	}
	
	public function withPassword(string $password) : self
	{
		return $this->addState(['password' => $password]);
	}
	
	public function withPlainPassword(string $password) : self
	{
		return $this->addState(['plainPassword' => $password]);
	}
	
	public function withRoles(array $roles): self
	{
		return $this->addState(['roles' => $roles]);
	}
}