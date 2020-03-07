<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
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
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @Assert\NotBlank
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $phone;

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getBirthDate()
    {
        return $this->birthdate;
    }

    public function setBirthDate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
}
