<?php
namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Accommodation;
use App\Entity\Guest;
use App\Repository\AccommodationRepository;

class AccommodationController extends AbstractController
{
	private $em;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}
	
	public function guests(string $id, string $guestId)
	{
		$accommodation = $this->em->getRepository(Accommodation::class)->find($id);
		if($accommodation === null) return new Response('Accommodation not found.', Response::HTTP_NOT_FOUND);
		
		$guest = $this->em->getRepository(Guest::class)->find($guestId);
		if($guest === null) return new Response('Guest not found.', Response::HTTP_NOT_FOUND);
		
		$accommodation->addGuest($guest);
		$this->em->flush();
		
		return $accommodation;
	}
	
	public function rooms(string $id, string $roomId)
	{
		var_dump('rooms action', $id, $roomId);
		return null;
	}
}