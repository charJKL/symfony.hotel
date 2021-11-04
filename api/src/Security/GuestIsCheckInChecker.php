<?php
namespace App\Security;

use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Guest;
use App\Entity\Accommodation;

class GuestIsCheckInChecker implements UserCheckerInterface
{
	private $em;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}
	
	public function checkPreAuth(UserInterface $user): void
	{
		if(!$user instanceof Guest) return;
		
		$accommodations = $this->em->getRepository(Accommodation::class)->findAllForGuest($user);
		foreach($accommodations as $accommodation)
		{
			if($accommodation->getStatus() === Accommodation::CHECKED_IN) return;
		}
		throw new CustomUserMessageAccountStatusException('You are not hotel Guest.');
	}
	
	public function checkPostAuth(UserInterface $user): void
	{
		if(!$user instanceof Guest) return;
	}
}