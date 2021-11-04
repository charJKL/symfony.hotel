<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;

class SecurityController extends AbstractController
{
	const HTTP_200_OK = Response::HTTP_OK;
	const HTTP_401_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
	
	/**
	 * @Route("/login", name="login", methods={"POST"})
	 */
	public function login()
	{
		if($this->isGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY) === false)
		{
			return new Response(null, self::HTTP_401_UNAUTHORIZED);
		}
		
		$user = $this->getUser();
		$account = ['login' => $user->getId()];
		return new JsonResponse($account, self::HTTP_200_OK);
	}
	
	public function guest()
	{
		if($this->isGranted(AuthenticatedVoter::IS_AUTHENTICATED_FULLY) === false)
		{
			return new Response(null, self::HTTP_401_UNAUTHORIZED);
		}
		
		$user = $this->getUser();
		$account = ['login' => $user->getId()];
		return new JsonResponse($account, self::HTTP_200_OK);
	}
	
	/**
	 * @Route("/logout", name="logout")
	 */ 
	public function logout()
	{
		
	}
}