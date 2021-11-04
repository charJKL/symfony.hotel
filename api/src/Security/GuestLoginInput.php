<?php
namespace App\Security;

class GuestLoginInput
{
	public string $identifier;
	
	public string $password;
}