<?php

namespace App\Entity\Data;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Data\CityRepository")
 * @ORM\Table(name="cities")
 */
class City
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
    private $name;

    /**
     * Many Cities has One Region.
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="city")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $region;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): self
    {
        $this->region = $region;
        return $this;
    }
}
