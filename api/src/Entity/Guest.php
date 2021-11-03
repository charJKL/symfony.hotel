<?php
namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GuestRepository;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GuestRepository::class)
 */
class Guest implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nationality;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"accommodation:create"})
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $documentId;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"accommodation:create"})
	 */
   private $phone;
   
	/**
	 * @ORM\Column(type="json", nullable=true)
	 */
	private $roles = [];
	
	/**
	 * @var string The hashed password
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $password;
	
	/**
	 * @var string Password in plain form.
	 */ 
	private $plainPassword;
	
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }

    public function setDocumentId(?string $documentId): self
    {
        $this->documentId = $documentId;

        return $this;
    }
	 
	/**
	 * @see UserInterface
	 * @deprecated since Symfony 5.3
	 */ 
	public function getUsername()
	{
		return (string) $this->id;
	}
	
	/**
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
	{
		return (string) $this->id;
	}

	/**
	 * @see UserInterface
	 */ 
	public function getRoles(): array
	{
		$roles = $this->roles;
		$roles[] = 'ROLE_USER';
		return array_unique($roles);
	}
	
	public function setRoles(array $roles) : self
	{
		$this->roles = $roles;
		return $this;
	}
	
	public function setPlainPassword(string $password) : self
	{
		$this->plainPassword = $password;
		return $this;
	}
	
	public function getPlainPassword() : ?string
	{
		return $this->plainPassword;
	}
	
	/**
	 * @see PasswordAuthenticatedUserInterface
	 */ 
	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;
		return $this;
	}
	
	/**
	 * @see UserInterface
	 */ 
	public function getSalt(): ?string
	{
		return null;
	}

	/**
	 * @see UserInterface
	 */ 
	public function eraseCredentials()
	{
		$this->plainPassword = null;
	}
}
