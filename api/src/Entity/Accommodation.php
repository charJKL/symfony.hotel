<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AccommodationRepository;

/**
 * @ApiResource(
 * 	collectionOperations = {
 * 		"get",
 * 		"post" = { "denormalization_context"={"groups"={"accommodation:create"}} },
 * 	},
 * 	itemOperations = {
 * 		"get",
 * 		"patch"
 * 	}
 * )
 * @ORM\Entity(repositoryClass=AccommodationRepository::class)
 */
class Accommodation
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", options={"unsigned":true})
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="integer", options={"unsigned":true})
	 */
	private $status;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Groups({"accommodation:create"})
	 */
	private $checkInAt;

	/**
	 * @ORM\Column(type="datetime")
	 * @Groups({"accommodation:create"})
	 */
	private $checkOutAt;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $bookAt;
	
	/**
	 * @ORM\Column(type="integer", options={"unsigned":true})
	 * @Groups({"accommodation:create"})
	 */
	private $roomsAmount;

	/**
	 * @ORM\Column(type="integer", options={"unsigned":true})
	 * @Groups({"accommodation:create"})
	 */
	private $peopleAmount;
	
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Room")
	 */
	private $rooms;
	
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Guest", cascade={"persist"})
	 * @Groups({"accommodation:create"})
	 */ 
	private $guests;
	
	const BOOKED = 0;
	const CONFIRMED = 1;
	const CHECKED_IN = 2;
	const CHECKED_OUT = 3;
	
	public function __construct()
	{
		$this->status = self::BOOKED;
		$this->rooms = new ArrayCollection();
		$this->guests = new ArrayCollection();
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCheckInAt(): ?\DateTimeInterface
    {
        return $this->checkInAt;
    }

    public function setCheckInAt(\DateTimeInterface $checkInAt): self
    {
        $this->checkInAt = $checkInAt;

        return $this;
    }

    public function getCheckOutAt(): ?\DateTimeInterface
    {
        return $this->checkOutAt;
    }

    public function setCheckOutAt(\DateTimeInterface $checkOutAt): self
    {
        $this->checkOutAt = $checkOutAt;

        return $this;
    }

    public function getBookAt(): ?\DateTimeInterface
    {
        return $this->bookAt;
    }

    public function setBookAt(?\DateTimeInterface $bookAt): self
    {
        $this->bookAt = $bookAt;

        return $this;
    }

    public function getRoomsAmount(): ?int
    {
        return $this->roomsAmount;
    }

    public function setRoomsAmount(int $roomsAmount): self
    {
        $this->roomsAmount = $roomsAmount;

        return $this;
    }

    public function getPeopleAmount(): ?int
    {
        return $this->peopleAmount;
    }

    public function setPeopleAmount(int $peopleAmount): self
    {
        $this->peopleAmount = $peopleAmount;

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        $this->rooms->removeElement($room);

        return $this;
    }

    /**
     * @return Collection|Guest[]
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(Guest $guest): self
    {
        if (!$this->guests->contains($guest)) {
            $this->guests[] = $guest;
        }

        return $this;
    }

    public function removeGuest(Guest $guest): self
    {
        $this->guests->removeElement($guest);

        return $this;
    }
}