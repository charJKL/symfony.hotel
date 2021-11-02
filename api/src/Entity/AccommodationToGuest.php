<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource(
 * 	collectionOperations = { },
 * 	itemOperations = {
 * 		"put" = { "path" = "/accommodation/{accommodation_id}/guest/{guest_id}" },
 * 		"delete" = { "path" = "/accommodation/{accommodation_id}/guest/{guest_id}" },
 * 	}
 * )
 */
class AccommodationToGuest
{
	public int $id;
	
	public Accommodation $accommodation;
	
	public Guest $guest;
}