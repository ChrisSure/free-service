<?php
/**
 * Created by PhpStorm.
 * User: ktv911
 * Date: 21.11.19
 * Time: 12:25
 */

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\User\SocialUserRepository")
 * @ORM\Table(name="social_users")
 */
class SocialUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many SocialUsers has One User.
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\User", inversedBy="social", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",  nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $social_id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $provider;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $social_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $social_image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $social_token;


    /**
     * @var array
     */
    public static $listProviders = ['facebook', 'google'];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return SocialUser
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getSocialId(): string
    {
        return $this->social_id;
    }

    /**
     * @param mixed $social_id
     * @return SocialUser
     */
    public function setSocialId($social_id): self
    {
        $this->social_id = $social_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     * @return SocialUser
     */
    public function setProvider($provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return string
     */
    public function getSocialName(): string
    {
        return $this->social_name;
    }

    /**
     * @param mixed $social_name
     * @return SocialUser
     */
    public function setSocialName($social_name): self
    {
        $this->social_name = $social_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSocialImage(): string
    {
        return $this->social_image;
    }

    /**
     * @param mixed $social_image
     * @return SocialUser
     */
    public function setSocialImage($social_image): self
    {
        $this->social_image = $social_image;
        return $this;
    }

    /**
     * @return string
     */
    public function getSocialToken(): string
    {
        return $this->social_token;
    }

    /**
     * @param mixed $social_token
     * @return SocialUser
     */
    public function setSocialToken($social_token): self
    {
        $this->social_token = $social_token;
        return $this;
    }

}