<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoomsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RoomsRepository::class)
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
	 */ 
	private $number;
	
    /**
     * @ORM\Column(type="string", length=255)
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
}
