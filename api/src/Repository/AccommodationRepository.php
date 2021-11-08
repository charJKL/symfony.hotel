<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Guest;
use App\Entity\Accommodation;
use App\Entity\Room;

/**
 * @method Accommodation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accommodation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accommodation[]    findAll()
 * @method Accommodation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccommodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accommodation::class);
    }
	
	/**
	 * @return Accommodation[]
	 */ 
	public function findAllForGuest(Guest $guest) : array
	{
		$dql = "SELECT a FROM App\\Entity\\Accommodation a JOIN App\\Entity\\Guest g WHERE g.id = :id ORDER BY a.checkInAt DESC";
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('id', $guest->getId());
		return $query->getResult();
	}
	
	/**
	 * @return Accommodation
	 */ 
	public function findCurrentForRoom(int $room_id) : ?Accommodation
	{
		$dql = "SELECT a FROM App\\Entity\\Accommodation a JOIN a.rooms r WHERE a.status = :status_check_in AND r.id = :room_id";
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter('status_check_in', Accommodation::CHECKED_IN);
		$query->setParameter('room_id', $room_id);
		return $query->getOneOrNullResult();
	}
	
	
	
    // /**
    //  * @return Accommodation[] Returns an array of Accommodation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Accommodation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
