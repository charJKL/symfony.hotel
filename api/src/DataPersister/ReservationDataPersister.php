<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Reservation;

class ReservationDataPersister implements ContextAwareDataPersisterInterface
{
	private $decoratedDataPersister;
	
	public function __construct(DataPersisterInterface $decoratedDataPersister)
	{
		$this->decoratedDataPersister = $decoratedDataPersister;
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
			$data->setCheckInAt($data->getCheckInAt()->setTime(11,0,0,0));
			$data->setCheckOutAt($data->getCheckOutAt()->setTime(10,0,0,0));
		}
		
		$this->decoratedDataPersister->persist($data);
	}
	
	public function remove($data, array $context = [])
	{
		$this->decoratedDataPersister->remove($data);
	}
	
}

