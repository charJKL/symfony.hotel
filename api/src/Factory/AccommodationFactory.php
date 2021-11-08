<?php
namespace App\Factory;

use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use App\Entity\Accommodation;
use App\Factory\Utils\DateTimeProvider;
use App\Repository\AccommodationRepository;
use DateTime;

/**
 * @extends ModelFactory<Accommodation>
 *
 * @method static Accommodation|Proxy createOne(array $attributes = [])
 * @method static Accommodation[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Accommodation|Proxy find(object|array|mixed $criteria)
 * @method static Accommodation|Proxy findOrCreate(array $attributes)
 * @method static Accommodation|Proxy first(string $sortedField = 'id')
 * @method static Accommodation|Proxy last(string $sortedField = 'id')
 * @method static Accommodation|Proxy random(array $attributes = [])
 * @method static Accommodation|Proxy randomOrCreate(array $attributes = [])
 * @method static Accommodation[]|Proxy[] all()
 * @method static Accommodation[]|Proxy[] findBy(array $attributes)
 * @method static Accommodation[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Accommodation[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AccommodationRepository|RepositoryProxy repository()
 * @method Accommodation|Proxy create(array|callable $attributes = [])
 */
final class AccommodationFactory extends ModelFactory
{	
	public function __construct()
	{
		parent::__construct();
		self::faker()->addProvider(new DateTimeProvider(self::faker()));
	}
	
	protected static function getClass(): string
	{
		return Accommodation::class;
	}
	
	protected function getDefaults(): array
	{
		$checkInAt = self::faker()->dateTimeBetween('+1 week', '+1 month');
		$checkOutAt = self::faker()->dateTimeBetween($checkInAt, '+1 month');
		return [
			'status' => Accommodation::BOOKED,
			'checkInAt' => $checkInAt,
			'checkOutAt' => $checkOutAt,
			'roomsAmount' => self::faker()->numberBetween(1, 4),
			'peopleAmount' => self::faker()->numberBetween(1, 4),
		];
	}
	
	public function status($status) : self
	{
		return $this->addState(['status' => $status]);
	}
	
	public function forDays($from, $days) : self
	{
		$checkInAt = self::faker()->exactDateTime($from);
		$checkOutAtLatest = DateTime::createFromInterface($checkInAt)->modify("+$days days");
		$checkOutAt = self::faker()->dateTimeBetween($checkInAt, $checkOutAtLatest);
		
		return $this->addState(['checkInAt' => $checkInAt, 'checkOutAt' => $checkOutAt]);
	}
	
	public function forPeriod($from, $to) : self
	{
		$checkInAt = self::faker()->dateTimeBetween($from, $to);
		$checkOutAt = self::faker()->dateTimeBetween($checkInAt, $to);
		return $this->addState(['checkInAt' => $checkInAt, 'checkOutAt'=> $checkOutAt]);
	}
	
	public function withRooms(array $rooms) : self
	{
		return $this->addState(['rooms' => $rooms]);
	}
	
	public function withGuests(array $guests) : self
	{
		return $this->addState(['guests' => $guests]);
	}
}
