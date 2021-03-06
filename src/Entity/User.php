<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Vich\Uploadable()
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
     * @var string
     */
    private $fullName;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotNull(message="Saisis la date de ton entrée au royaume")
     */
    private $enteredAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $knightedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\County", inversedBy="users")
     * @Assert\NotBlank(message="Choisis une contrée")
     */
    private $county;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="godChildren")
     */
    private $buddy;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="buddy")
     */
    private $godChildren;

    /**
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="imageName")
     * @Assert\File(
     *     mimeTypes={ "image/jpg", "image/png", "image/jpeg", "image/gif" },
     *     maxSize="2M",
     *     mimeTypesMessage="Veuillez choisir un fichier de type .jpg, .jpeg, .png ou .gif",
     *     maxSizeMessage="Veuillez choisir un fichier de 1.9Mo maximum"
     *  )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Job", inversedBy="users")
     */
    private $jobs;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetPasswordToken;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gender", inversedBy="users")
     */
    private $gender;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trade", inversedBy="users")
     */
    private $trades;

    public function __construct()
    {
        $this->godChildren = new ArrayCollection();
        $this->jobs = new ArrayCollection();
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

    public function setKnightedAt(?\DateTimeInterface $knightedAt): self
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBuddy(): ?self
    {
        return $this->buddy;
    }

    public function setBuddy(?self $buddy): self
    {
        $this->buddy = $buddy;

        return $this;
    }

    public function getPasswordRequestedAt(): ?\DateTime
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequestedAt(?\DateTime $passwordRequestedAt): self
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken): self
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getGodchildren(): Collection
    {
        return $this->godChildren;
    }

    public function addGodchild(self $user): self
    {
        if (!$this->godChildren->contains($user)) {
            $this->godChildren[] = $user;
            $user->setBuddy($this);
        }

        return $this;
    }

    public function removeGodchild(self $user): self
    {
        if ($this->godChildren->contains($user)) {
            $this->godChildren->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getBuddy() === $this) {
                $user->setBuddy(null);
            }
        }

        return $this;
    }

    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $this->addTrade($job->getTrade());
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->contains($job)) {
            $this->jobs->removeElement($job);
            $this->removeTrade($job->getTrade());
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return ucfirst($this->firstname ). ' ' . ucfirst($this->lastname);
    }

    public function __toString()
    {
        return $this->getFullName();
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection|Trade[]
     */
    public function getTrades(): Collection
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
