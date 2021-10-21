<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Employee>
 *
 * @method static Employee|Proxy createOne(array $attributes = [])
 * @method static Employee[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Employee|Proxy find(object|array|mixed $criteria)
 * @method static Employee|Proxy findOrCreate(array $attributes)
 * @method static Employee|Proxy first(string $sortedField = 'id')
 * @method static Employee|Proxy last(string $sortedField = 'id')
 * @method static Employee|Proxy random(array $attributes = [])
 * @method static Employee|Proxy randomOrCreate(array $attributes = [])
 * @method static Employee[]|Proxy[] all()
 * @method static Employee[]|Proxy[] findBy(array $attributes)
 * @method static Employee[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Employee[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EmployeeRepository|RepositoryProxy repository()
 * @method Employee|Proxy create(array|callable $attributes = [])
 */
final class EmployeeFactory extends ModelFactory
{
	private static $hasher = null;
	
	public function __construct(UserPasswordHasherInterface $hasher)
	{
		parent::__construct();
		self::$hasher = $hasher;
	}

	protected static function getClass(): string
	{
		return Employee::class;
	}
	
	protected function getDefaults() : array
	{
		return [
			'uuid' => self::faker()->unique()->firstName(),
		];
	}
	
	protected function initialize() : self
	{
		return $this->afterInstantiate([self::class, 'afterInstantiateEmployee']);
	}
	
	public static function afterInstantiateEmployee(Employee $employee, array $attributes) : void
	{
		$password = $attributes['uuid'] . '-password';
		$employee->setPassword(self::$hasher->hashPassword($employee, $password));
	}
	
	public function password(string $password) : self
	{
		return $this->addState(['password' => $password]);
	}
	
	public function uuid(string $uuid) : self
	{
		return $this->addState(['uuid' => $uuid]);
	}
	
	public function withRoles(array $roles): self
	{
		return $this->addState(['roles' => $roles]);
	}
}
