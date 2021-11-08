<?php
namespace App\Service;

use App\Repository\AccommodationRepository;
use App\Entity\Room;
use App\Entity\Accommodation;

class AccommodationService
{
	private $accommodationRepository;
	
	public function __construct(AccommodationRepository $accommodationRepository)
	{
		$this->accommodationRepository = $accommodationRepository;
	}
	
	public function resolveForRoom(Room $room) : ?Accommodation
	{
		return $this->accommodationRepository->findCurrentForRoom($room->getId());
	}
}