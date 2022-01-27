<?php

namespace App\Factory;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Offer>
 *
 * @method static Offer|Proxy createOne(array $attributes = [])
 * @method static Offer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Offer|Proxy find(object|array|mixed $criteria)
 * @method static Offer|Proxy findOrCreate(array $attributes)
 * @method static Offer|Proxy first(string $sortedField = 'id')
 * @method static Offer|Proxy last(string $sortedField = 'id')
 * @method static Offer|Proxy random(array $attributes = [])
 * @method static Offer|Proxy randomOrCreate(array $attributes = [])
 * @method static Offer[]|Proxy[] all()
 * @method static Offer[]|Proxy[] findBy(array $attributes)
 * @method static Offer[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Offer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OfferRepository|RepositoryProxy repository()
 * @method Offer|Proxy create(array|callable $attributes = [])
 */
final class OfferFactory extends ModelFactory
{
	protected static function getClass(): string
	{
		return Offer::class;
	}
	
	protected function getDefaults(): array
	{
		return [
			'name' => self::faker()->words(2),
			'description' => self::faker()->sentences(3, true),
		];
	}
	
	public function withName(string $name) : self
	{
		return $this->addState(['name' => $name]);
	}
	
	public function withImage(string $path) : self
	{
		return $this->addState(['image' => $path]);
	}
}
