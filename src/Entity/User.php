<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message:"username is required")]
    private ?string $username = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Phone number is required")]
    #[Assert\Length(min:8,minMessage:" please add a valid phone number")]
    private ?int $phone = null;
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;
   
    #[ORM\Column]
    private ?string $img = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message:"Email is required")]
    #[Assert\Email(message:'The email "{{ value }}" is not a valid email.')]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"name is required")]
    private ?string $name = null;
    #[ORM\Column]
    #[Assert\NotBlank(message:"lastname is required")]
    private ?string $lastName = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Subscription $id_subscription = null;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $CoursesUser;




   

    public function __construct()
    {
        $this->CoursesUser = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }
    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
    public function getImg(): ?String
    {
        return $this->img;
    }

    public function setImg(?String $img): static
    {
        $this->img = $img;

        return $this;
    }
    public function getName(): ?String
    {
        return $this->name;
    }

    public function setName(?String $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function getlastName(): ?String
    {
        return $this->lastName;
    }

    public function setlastName(?String $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIdSubscription(): ?Subscription
    {
        return $this->id_subscription;
    }

    public function setIdSubscription(?Subscription $id_subscription): static
    {
        $this->id_subscription = $id_subscription;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCoursesUser(): Collection
    {
        return $this->CoursesUser;
    }

    public function addCoursesUser(Course $coursesUser): static
    {
        if (!$this->CoursesUser->contains($coursesUser)) {
            $this->CoursesUser->add($coursesUser);
            $coursesUser->setUser($this);
        }

        return $this;
    }

    public function removeCoursesUser(Course $coursesUser): static
    {
        if ($this->CoursesUser->removeElement($coursesUser)) {
            // set the owning side to null (unless already changed)
            if ($coursesUser->getUser() === $this) {
                $coursesUser->setUser(null);
            }
        }

        return $this;
    }

    
  
}
