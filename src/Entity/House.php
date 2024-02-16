<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use App\Entity\Picture;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\HouseRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass: HouseRepository::class)]
class House
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $rooms;

    #[ORM\Column(type: 'integer')]
    private $area;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\ManyToMany(targetEntity: Option::class, inversedBy: 'houses', cascade: ['persist'])]
    private $options;

    private $imageFiles;

    #[ORM\OneToMany(mappedBy: 'house', targetEntity: Picture::class, cascade: ['persist'], orphanRemoval: true)]
    private $pictures;


    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

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

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }
    

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setHouse($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getHouse() === $this) {
                $picture->setHouse(null);
            }
        }

        return $this;
    }

    public function getImageFiles()
    {
        return $this->imageFiles;
    }
 
    public function setImageFiles($imageFiles):self
    {
        foreach($imageFiles as $imageFile)
        {
            $picture = new Picture;
            $picture->setImageFile($imageFile);
            $this->addPicture($picture);
        }
        $this->imageFiles = $imageFiles;

        return $this;
    }
}
