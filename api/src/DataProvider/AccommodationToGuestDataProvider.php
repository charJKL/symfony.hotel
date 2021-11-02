<?php
namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Relation\AccommodationToGuest;

final class AccommodationToGuestDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
	{
		return AccommodationToGuestDataProvider::class === $resourceClass;
	}

	public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ? AccommodationToGuest
	{
		// TODO fail, becouse API platform require that path will contain $id attribute.
		echo "id: $id";
		var_dump($context);
		var_dump("gitted");
		return new AccommodationToGuest(null, null);
	}
}