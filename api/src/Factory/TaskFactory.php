<?php

namespace App\Factory;

use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use App\Repository\TaskRepository;
use App\Entity\Task;
use App\Entity\Room;
use App\Entity\Service;
use App\Service\AccommodationService;
use LogicException;
use Symfony\Component\HttpKernel\Log\Logger;

/**
 * @extends ModelFactory<Task>
 *
 * @method static Task|Proxy createOne(array $attributes = [])
 * @method static Task[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Task|Proxy find(object|array|mixed $criteria)
 * @method static Task|Proxy findOrCreate(array $attributes)
 * @method static Task|Proxy first(string $sortedField = 'id')
 * @method static Task|Proxy last(string $sortedField = 'id')
 * @method static Task|Proxy random(array $attributes = [])
 * @method static Task|Proxy randomOrCreate(array $attributes = [])
 * @method static Task[]|Proxy[] all()
 * @method static Task[]|Proxy[] findBy(array $attributes)
 * @method static Task[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Task[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TaskRepository|RepositoryProxy repository()
 * @method Task|Proxy create(array|callable $attributes = [])
 */
final class TaskFactory extends ModelFactory
{
	private $accommodationService;
	
	public function __construct(AccommodationService $accommodationService)
	{
		parent::__construct();
		$this->accommodationService = $accommodationService;
	}
	
	protected static function getClass(): string
	{
		return Task::class;
	}
	
	protected function getDefaults(): array
	{
		return [
			'status' => Task::CREATED,
			'createTime' => null,
			'service' => null, 
			'room' => null,
		];
	}
	
	protected function initialize() : self
	{
		return $this->beforeInstantiate([$this, 'beforeInstantiateTask']);
	}
	
	public function beforeInstantiateTask(array $attributes) : array
	{
		if($attributes['room'] === null) throw new LogicException("To create Task fixture you must inject `Room` TaskFactory::new()->withRoom(...).");
		if($attributes['service'] === null) throw new LogicException("To create Task fixture you must inject `Service` TaskFactory::new()->withService(...)");
		
		$accommodation = $this->accommodationService->resolveForRoom($attributes['room']);
		if($accommodation === null) throw new LogicException("Associated `Room` isn't assigned to active `Accommodation`");
		$attributes['createTime'] = self::faker()->dateTimeBetween($accommodation->getCheckInAt(), $accommodation->getCheckOutAt());
		return $attributes;
	}
	
	public function withService($service) : self
	{
		return $this->addState(['service' => $service]);
	}
	
	public function withRoom($room) : self
	{
		return $this->addState(['room' => $room]);
	}
}
