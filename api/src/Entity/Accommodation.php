<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AccommodationRepository;
use App\Controller\AccommodationController;

/**
 * @ApiResource(
 * 	collectionOperations = {
 * 		"get",
 * 		"post" = { "denormalization_context"={"groups"={"accommodation:create"}} },
 * 	},
 * 	itemOperations = {
 * 		"get",
 * 		"patch" = { "security" = "is_granted('ROLE_USER')", "denormalization_context"={"groups"={"accommodation:update"}} },
 * 		"add_guests" = { "method" = "PUT", "path" = "/accommodations/{accommodation_id}/guests/{guest_id}", "controller"="App\Controller\AccommodationController::add_guests", "read" = false, "deserialize" = false, "validate" = false, "write" = false },
 * 		"remove_guests" = { "method" = "DELETE", "path" = "/accommodations/{accommodation_id}/guests/{guest_id}", "controller"="App\Controller\AccommodationController::remove_guests", "read" = false, "deserialize" = false, "validate" = false, "write" = false }
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
	 * @Groups({"accommodation:update"})
	 */
	private $status;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Groups({"accommodation:create", "accommodation:update"})
	 */
	private $checkInAt;

	/**
	 * @ORM\Column(type="datetime")
	 * @Groups({"accommodation:create"})
	 */
	private $checkOutAt;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Room")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $room;
	
	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Guest", cascade={"persist"})
	 * @Groups({"accommodation:create", "accommodation:update"})
	 */ 
	private $guests;

    /**
     * @ORM\ManyToOne(targetEntity=Reservation::class, inversedBy="accommodations")
     */
    private $reservation;
	
	const BOOKED = 0;
	const CONFIRMED = 1;
	const CHECKED_IN = 2;
	const CHECKED_OUT = 3;
	
	public function __construct()
	{
		$this->status = self::BOOKED;
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

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): self
    {
        $this->room = $room;

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

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}