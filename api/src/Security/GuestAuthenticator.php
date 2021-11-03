<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use App\Entity\Guest;


class GuestAuthenticator extends AbstractAuthenticator
{
	private $hasher;
	private $em;
	private $httpUtils;

	public function __construct(UserPasswordHasherInterface $hasher, EntityManagerInterface $em, HttpUtils $httpUtils)
	{
		$this->hasher = $hasher;
		$this->em = $em;
		$this->httpUtils = $httpUtils;
	}
	
	public function supports(Request $request): ?bool
	{
		if($this->httpUtils->checkRequestPath($request, '/guest/login') === false) return false;
		if(strpos($request->getContentType(), 'json') === false) return false;
		return true;
	}
	
	public function authenticate(Request $request): PassportInterface
	{
		[$username, $password] = $this->getCredentials($request);

		$guestByEmail = $this->em->getRepository(Guest::class)->findByEmail($username);
		$guestByPhone = $this->em->getRepository(Guest::class)->findByPhone($username);
		
		$guests = array_merge($guestByEmail, $guestByPhone);
		foreach($guests as $guest)
		{
			if($this->hasher->isPasswordValid($guest, $password) === true)
			{
				$userBadge = new UserBadge($guest->getId());
				$credentials = new PasswordCredentials($password);
				$passport = new Passport($userBadge, $credentials);
				return $passport;
			}
		}
		throw new BadCredentialsException('Invalid credentials.');
	}
	
	public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
	{
		return null;
	}
		
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
	{
		$data = [
				// you may want to customize or obfuscate the message first
				'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
					// or to translate this message
				// $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
		];
			return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
	}
	
	private function getCredentials(Request $request) : array
	{
		$credentials = [];
		$credentials['username'] = '';
		$credentials['password'] = '';
		$data = json_decode($request->getContent());

		if($data === null) throw new BadRequestHttpException('Invalid JSON.');
		if(isset($data->username) === false) throw new BadRequestHttpException("Missing 'username' property.");
		if(isset($data->password) === false) throw new BadRequestHttpException("Missing 'password' property.");
		
		if(is_string($data->username) === false) throw new BadCredentialsException('Username value must be string.');
		if(strlen($data->username) > Security::MAX_USERNAME_LENGTH) throw new BadCredentialsException('Username is too long.');
		if(is_string($data->password) === false) throw new BadCredentialsException('Password must be string.');

		return [$data->username, $data->password];
	}
}