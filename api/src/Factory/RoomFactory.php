<?php

namespace App\Factory;

use App\Entity\Room;
use App\Repository\RoomsRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

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
	public function __construct()
	{
		parent::__construct();
		$faker = self::faker()->addProvider(new RoomProvider(self::faker()));
	}
	
	protected function getDefaults(): array
	{
		return 
		[
			'name' =>  self::faker()->room(0, 100),
			'facilities' => FacilityFactory::randomRange(1, 5)
		];
	}

	protected static function getClass(): string
	{
		return Room::class;
	}
	
	public static function room($from, $to) : string
	{
		return self::faker()->room($from, $to);
	}
}
