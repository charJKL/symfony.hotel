<?php

namespace App\Factory;

use App\Entity\Facility;
use App\Repository\FacilitiesRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Facility>
 *
 * @method static Facility|Proxy createOne(array $attributes = [])
 * @method static Facility[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Facility|Proxy find(object|array|mixed $criteria)
 * @method static Facility|Proxy findOrCreate(array $attributes)
 * @method static Facility|Proxy first(string $sortedField = 'id')
 * @method static Facility|Proxy last(string $sortedField = 'id')
 * @method static Facility|Proxy random(array $attributes = [])
 * @method static Facility|Proxy randomOrCreate(array $attributes = [])
 * @method static Facility[]|Proxy[] all()
 * @method static Facility[]|Proxy[] findBy(array $attributes)
 * @method static Facility[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Facility[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FacilitiesRepository|RepositoryProxy repository()
 * @method Facility|Proxy create(array|callable $attributes = [])
 */
final class FacilityFactory extends ModelFactory
{
	public function __construct()
	{
		parent::__construct();
		$faker = self::faker()->addProvider(new FacilityProvider(self::faker()));
	}
	
	protected function getDefaults(): array
	{
		return 
		[
			'name' => self::faker()->facility(),
			'description' => self::faker()->sentence()
		];
	}

	protected static function getClass(): string
	{
		return Facility::class;
	}
}
