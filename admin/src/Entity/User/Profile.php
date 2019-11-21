<?php

namespace App\Entity\User;

use App\Entity\Data\City;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\ProfileRepository")
 * @ORM\Table(name="profiles")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $phone;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * One Profile has One User.
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * Many Profiles has One City.
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\City", inversedBy="profile")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $city;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Profile
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Profile
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param null|string $surname
     * @return Profile
     */
    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @param null|string $about
     * @return Profile
     */
    public function setAbout(?string $about): self
    {
        $this->about = $about;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return Profile
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSex(): ?int
    {
        return $this->sex;
    }

    /**
     * @param int|null $sex
     * @return Profile
     */
    public function setSex(?int $sex): self
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * @return int
     */
    public function getBirthday(): int
    {
        return $this->birthday;
    }

    /**
     * @param $birthday
     * @return Profile
     */
    public function setBirthday($birthday): self
    {
        $date = date_create($birthday);
        $this->birthday = $date;
        return $this;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
        return $this;
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime("now");
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Profile
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return Profile
     */
    public function setCity(City $city): self
    {
        $this->city = $city;
        return $this;
    }
}
