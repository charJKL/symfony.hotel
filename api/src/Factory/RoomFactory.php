<?php
namespace App\Factory;

use App\Entity\Room;
use App\Repository\RoomsRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use BadFunctionCallException;

/**
 * @extends ModelFactory<Room>
 *
 * @method static Room|Proxy createOne(array $attributes = [])
 * @method static Room[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Room|Proxy find(object|array|mixed $criteria)
 * @method static Room|Proxy findOrCreate(array $attributes)
 * @method static Room|Proxy first(string $sortedField = 'id')
 * @method static Room|Proxy last(string $sortedField = 'id')
 * @method static Room|Proxy random(array $attributes = [])
 * @method static Room|Proxy randomOrCreate(array $attributes = [])
 * @method static Room[]|Proxy[] all()
 * @method static Room[]|Proxy[] findBy(array $attributes)
 * @method static Room[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Room[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RoomsRepository|RepositoryProxy repository()
 * @method Room|Proxy create(array|callable $attributes = [])
 */
final class RoomFactory extends ModelFactory
{
	protected static function getClass(): string
	{
		return Room::class;
	}
	
	protected function getDefaults(): array
	{
		return 
		[
			'number' => self::faker()->unique()->numberBetween(0, 100),
			'name' => null,
			'facilities' => []
		];
	}
	
	protected function initialize() : self
	{
		return $this->beforeInstantiate([self::class, 'beforeInstantiateRoom']);
	}
	
	public static function beforeInstantiateRoom(array $attributes) : array
	{
		if(isset($attributes['name']) === false) $attributes['name'] = 'Room ' . $attributes['number'];
		return $attributes;
	}
	
	public function __call(string $name, array $arguments) : mixed
	{
		$withNumber = 'withNumber';
		$args = count($arguments);
		if($name === $withNumber && $args === 1) return $this->withNumberExact(...$arguments);
		if($name === $withNumber && $args === 2) return $this->withNumberBetween(...$arguments);
		
		throw new BadFunctionCallException('Call to undefined method "'.self::class.'::'.$name.'".');
	}
	
	public function withName(string $name) : self
	{
		return $this->addState(['name' => $name]);
	}
	
	public function withFacilities(array $facilities) : self
	{
		return $this->addState(['facilities' => $facilities]);
	}
	
	private function withNumberExact(int $number) : self
	{
		return $this->addState(['number' => $number]);
	}
	
	private function withNumberBetween(int $from, int $to) : self
	{
		return $this->addState(['number' => self::faker()->unique()->numberBetween($from, $to)]);
	}
}