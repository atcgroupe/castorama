<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @UniqueEntity(
 *     fields={"name", "user"},
 *     errorPath="name",
 *     message="Ce nom est déjà utilisé par un autre membre de votre équipe."
 * )
 * @UniqueEntity("email", message="Cette adresse mail est déjà utilisée par un autre membre.")
 */
class Member
{
    public const SESSION_ID = 'member';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"member_session"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le nom du membre est obligatoire")
     * @Groups({"member_session"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(message="Cette adresse mail n'est pas valide.")
     * @Groups({"member_session"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="member")
     */
    private $orders;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class)
     * @Groups({"member_session"})
     */
    private $events;

    /**
     * @ORM\Column(type="boolean")
     */
    private $amountAlert;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amountLevel;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDisplayName(): string
    {
        $suffix = '';
        if (null !== $this->getUser() && $this->getUser()->getRoles() === [User::ROLE_CUSTOMER_ADMIN]) {
            $suffix = ' (Siège)';
        }

        return $this->getName() . $suffix;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setMember($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getMember() === $this) {
                $order->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->events->removeElement($event);

        return $this;
    }

    public function getAmountAlert(): ?bool
    {
        return $this->amountAlert;
    }

    public function setAmountAlert(bool $amountAlert): self
    {
        $this->amountAlert = $amountAlert;

        return $this;
    }

    public function getAmountLevel(): ?int
    {
        return $this->amountLevel;
    }

    public function setAmountLevel(?int $amountLevel): self
    {
        $this->amountLevel = $amountLevel;

        return $this;
    }
}
