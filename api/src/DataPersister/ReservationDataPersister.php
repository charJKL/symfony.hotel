<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Reservation;
use InvalidArgumentException;

class ReservationDataPersister implements ContextAwareDataPersisterInterface
{
	private $decoratedDataPersister;
	private $checkInHour;
	private $checkOutHour;
	
	public function __construct(DataPersisterInterface $decoratedDataPersister, string $checkInHour, string $checkOutHour)
	{
		$this->decoratedDataPersister = $decoratedDataPersister;
		$this->checkInHour = $this->parseTime($checkInHour);
		$this->checkOutHour = $this->parseTime($checkOutHour);
	}
	
	public function supports($data, array $context = []): bool
	{
		return $data instanceof Reservation;
	}
	
	public function persist($data, array $context = [])
	{
		$isPostRequest = ($context['collection_operation_name'] ?? null) === 'post';
		if($isPostRequest === true)
		{
			$data->setCheckInAt($data->getCheckInAt()->setTime($this->checkInHour[0],$this->checkInHour[1]));
			$data->setCheckOutAt($data->getCheckOutAt()->setTime($this->checkOutHour[0],$this->checkOutHour[1]));
		}
		
		$this->decoratedDataPersister->persist($data);
	}
	
	public function remove($data, array $context = [])
	{
		$this->decoratedDataPersister->remove($data);
	}
	
	private function parseTime(string $time) : Array
	{
		if($time == "") throw new InvalidArgumentException("Time $time is in wrong format.");
		$parts = explode(":", $time);
		if(count($parts) < 2) throw new InvalidArgumentException("Time $time is in wrong format.");
		if(is_numeric($parts[0]) == false) throw new InvalidArgumentException("Time $time is in wrong format.");
		if(is_numeric($parts[1]) == false) throw new InvalidArgumentException("Time $time is in wrong format.");
		
		$hours = $parts[0];
		$minutes = $parts[1];
		if($hours < 0 || $hours > 23) throw new InvalidArgumentException("Time $time is in wrong format.");
		if($minutes < 0 || $minutes > 59) throw new InvalidArgumentException("Time $time is in wrong format.");
		return [$hours, $minutes];
	}
	
}

