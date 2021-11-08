<?php

namespace App\Factory;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Factory\Utils\ServiceProvider;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Service>
 *
 * @method static Service|Proxy createOne(array $attributes = [])
 * @method static Service[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Service|Proxy find(object|array|mixed $criteria)
 * @method static Service|Proxy findOrCreate(array $attributes)
 * @method static Service|Proxy first(string $sortedField = 'id')
 * @method static Service|Proxy last(string $sortedField = 'id')
 * @method static Service|Proxy random(array $attributes = [])
 * @method static Service|Proxy randomOrCreate(array $attributes = [])
 * @method static Service[]|Proxy[] all()
 * @method static Service[]|Proxy[] findBy(array $attributes)
 * @method static Service[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Service[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ServiceRepository|RepositoryProxy repository()
 * @method Service|Proxy create(array|callable $attributes = [])
 */
final class ServiceFactory extends ModelFactory
{
	public function __construct()
	{
		parent::__construct();
		self::faker()->addProvider(new ServiceProvider(self::faker()));
	}
	
	protected static function getClass(): string
	{
		return Service::class;
	}
	
	protected function getDefaults(): array
	{
		return [
			'name' => self::faker()->service(),
		];
	}
	
	public function withName(string $name) : self
	{
		return $this->addState(['name' => $name]);
	}
}
