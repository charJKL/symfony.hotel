<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\RoomRepository;

/**
 * @ApiResource(
 * 	attributes={"security"="is_granted('ROLE_USER')"},
 * )
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 * @UniqueEntity("number")
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
	
	/**
	 * @ORM\Column(type="integer", unique=true)
	 * @Assert\NotBlank()
	 */ 
	private $number;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\NotBlank()
	 */
	private $name;

	/**
	 * @ORM\ManyToMany(targetEntity="Facility")
	 */
	private $facilities;

	public function __construct(int $number, string $name)
         {
      		$this->facilities = new ArrayCollection();
      		$this->number = $number;
      		$this->name = $name;
         }

    public function getId(): ?int
    {
        return $this->id;
    }
	 
    public function getNumber(): ?int
    {
        return $this->number;
    }
	 
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return Collection|Facility[]
     */
    public function getFacilities(): Collection
    {
        return $this->facilities;
    }

    public function addFacility(Facility $facility): self
    {
        if (!$this->facilities->contains($facility)) {
            $this->facilities[] = $facility;
        }

        return $this;
    }

    public function removeFacility(Facility $facility): self
    {
        $this->facilities->removeElement($facility);

        return $this;
	 }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
