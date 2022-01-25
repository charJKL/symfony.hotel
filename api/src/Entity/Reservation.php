<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReservationRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * 	collectionOperations = {
 * 		"get" = {"normalization_context" = {"groups" = {"reservation:read"}}},
 * 		"post" = {"denormalization_context" = {"groups" = {"reservation:write"}}}
 * 	},
 * 	itemOperations = {
 * 		"get",
 * 		"patch"
 * 	}
 * )
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"unsigned":true})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
	  * @Groups({"reservation:read","reservation:write"})
	  * @Assert\GreaterThanOrEqual("today", message="Nie możesz zameldować się wcześniej niż {{ compared_value }}")
     */
    private $checkInAt;

    /**
     * @ORM\Column(type="datetime")
	  * @Groups({"reservation:read","reservation:write"})
     * @Assert\GreaterThan(propertyPath = "checkInAt", message="Nie możesz się wymeldować wcześniej niż {{ compared_value }}.")
     */
    private $checkOutAt;
	
    /**
     * @ORM\Column(type="datetime")
     */
    private $bookAt;

	/**
	 * @ORM\Column(type="string")
	 * @Groups({"reservation:write"})
	 * @Assert\NotBlank(message = "Podaj kontakt")
	 */
	private $contact;
	
	/**
	 * @ORM\Column(type="integer", options={"unsigned":true})
	 * @Groups({"reservation:write"})
	 * @Assert\Positive(message = "Liczba przewidywanych pokoi jest zła")
	 */
	private $roomsAmount;

	/**
	 * @ORM\Column(type="integer", options={"unsigned":true})
	 * @Groups({"reservation:write"})
	 * @Assert\Positive(message = "Liczba przewidywanych gości jest zła.")
	 */
	private $peopleAmount;

	/**
	 * @ORM\OneToMany(targetEntity=Accommodation::class, mappedBy="reservation")
	 */
	private $accommodations;

	const BOOKED = 1;
	const CONFIRMED = 2;
	const CANCELED = 3;

	public function __construct()
	{
		$this->status = Reservation::BOOKED;
		$this->bookAt = new DateTime();
		$this->accommodations = new ArrayCollection();
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
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

    public function setBookAt(\DateTimeInterface $bookAt): self
    {
        $this->bookAt = $bookAt;

        return $this;
    }

	public function getContact(): string
	{
		return $this->contact;
	}
	
	public function setContact(string $contact) : self
	{
		$this->contact = $contact;
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
     * @return Collection|Accommodation[]
     */
    public function getAccommodations(): Collection
    {
        return $this->accommodations;
    }

    public function addAccommodation(Accommodation $accommodation): self
    {
        if (!$this->accommodations->contains($accommodation)) {
            $this->accommodations[] = $accommodation;
            $accommodation->setReservation($this);
        }

        return $this;
    }

    public function removeAccommodation(Accommodation $accommodation): self
    {
        if ($this->accommodations->removeElement($accommodation)) {
            // set the owning side to null (unless already changed)
            if ($accommodation->getReservation() === $this) {
                $accommodation->setReservation(null);
            }
        }

        return $this;
    }
}
