<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Coquebert ! Saisis donc un email !")
     * @Assert\Email(message="Ton email n'est pas valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Coquebert ! Saisis donc un mot de passe !")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisis un prénom")
     * @Assert\Length(max="255", maxMessage="Saisis un prénom de moins de {{ limit }} caractères")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisis un nom")
     * @Assert\Length(max="255", maxMessage="Saisis un nom de moins de {{ limit }} caractères")
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Saisis la date de ton entrée au royaume")
     */
    private $enteredAt;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Saisis la date de ton adoubement")
     */
    private $knightedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\County", inversedBy="users")
     * @Assert\NotBlank(message="Choisis une contrée")
     */
    private $county;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trade", inversedBy="users")
     * @Assert\NotBlank(message="Choisis un corps de métier")
     */
    private $trades;

    public function __construct()
    {
        $this->trades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEnteredAt(): ?\DateTimeInterface
    {
        return $this->enteredAt;
    }

    public function setEnteredAt(\DateTimeInterface $enteredAt): self
    {
        $this->enteredAt = $enteredAt;

        return $this;
    }

    public function getKnightedAt(): ?\DateTimeInterface
    {
        return $this->knightedAt;
    }

    public function setKnightedAt(\DateTimeInterface $knightedAt): self
    {
        $this->knightedAt = $knightedAt;

        return $this;
    }

    public function getCounty(): ?County
    {
        return $this->county;
    }

    public function setCounty(?County $county): self
    {
        $this->county = $county;

        return $this;
    }

    /**
     * @return Collection|Trade[]
     */
    public function getTrade(): Collection
    {
        return $this->trades;
    }

    public function addTrade(Trade $trade): self
    {
        if (!$this->trades->contains($trade)) {
            $this->trades[] = $trade;
        }

        return $this;
    }

    public function removeTrade(Trade $trade): self
    {
        if ($this->trades->contains($trade)) {
            $this->trades->removeElement($trade);
        }

        return $this;
    }
}
