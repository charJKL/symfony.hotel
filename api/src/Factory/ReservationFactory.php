<?php

namespace App\Factory;

use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use App\Factory\Utils\DateTimeProvider;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;

/**
 * @extends ModelFactory<Reservation>
 *
 * @method static Reservation|Proxy createOne(array $attributes = [])
 * @method static Reservation[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Reservation|Proxy find(object|array|mixed $criteria)
 * @method static Reservation|Proxy findOrCreate(array $attributes)
 * @method static Reservation|Proxy first(string $sortedField = 'id')
 * @method static Reservation|Proxy last(string $sortedField = 'id')
 * @method static Reservation|Proxy random(array $attributes = [])
 * @method static Reservation|Proxy randomOrCreate(array $attributes = [])
 * @method static Reservation[]|Proxy[] all()
 * @method static Reservation[]|Proxy[] findBy(array $attributes)
 * @method static Reservation[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Reservation[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ReservationRepository|RepositoryProxy repository()
 * @method Reservation|Proxy create(array|callable $attributes = [])
 */
final class ReservationFactory extends ModelFactory
{
	public function __construct()
	{
		parent::__construct();
		self::faker()->addProvider(new DateTimeProvider(self::faker()));
	}
	
	protected static function getClass(): string
	{
		return Reservation::class;
	}
	
	protected function getDefaults(): array
	{
		$bookAt = self::faker()->dateTimeBetween('now', '+ 2 hour');
		$checkInAt = self::faker()->dateTimeBetween('+1 week', '+1 month');
		$checkOutAt = self::faker()->dateTimeBetween($checkInAt, '+1 month');
		return [
			'status' => Reservation::BOOKED,
			'bookAt' => $bookAt,
			'checkInAt' => $checkInAt,
			'checkOutAt' => $checkOutAt,
			'contact' => self::faker()->boolean() ? self::faker()->email() : self::faker()->numerify('+##-## ## ###'),
			'roomsAmount' => self::faker()->numberBetween(1, 4),
			'peopleAmount' => self::faker()->numberBetween(1, 4),
		];
	}
}
