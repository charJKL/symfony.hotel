<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Accommodation;
use App\Entity\Guest;
use App\Entity\Room;

class AccommodationController extends AbstractController
{
	private $em;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}
	
	public function add_guests(string $accommodation_id, string $guest_id)
	{
		$accommodation = $this->em->getRepository(Accommodation::class)->find($accommodation_id);
		if($accommodation === null) throw new NotFoundHttpException(sprintf('Accommodation #%s not found.', $accommodation_id));
		
		$guest = $this->em->getRepository(Guest::class)->find($guest_id);
		if($guest === null) throw new NotFoundHttpException(sprintf('Guest #%s not found.', $guest_id));
		
		$accommodation->addGuest($guest);
		$this->em->flush();
		
		return new Response('', 204);
	}
	
	public function remove_guests(string $accommodation_id, string $guest_id)
	{
		$accommodation = $this->em->getRepository(Accommodation::class)->find($accommodation_id);
		if($accommodation === null) throw new NotFoundHttpException(sprintf('Accommodation #%s not found.', $accommodation_id));
		
		$guest = $this->em->getRepository(Guest::class)->find($guest_id);
		if($guest === null) throw new NotFoundHttpException(sprintf('Guest #%s not found.', $guest_id));
		
		$accommodation->removeGuest($guest);
		$this->em->flush();
		
		return new Response('', 204);
	}
}