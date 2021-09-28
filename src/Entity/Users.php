<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface , \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255 , unique=true )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255 , unique=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255 )
     */
    private $role;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function  getRoles()
    {
$userRole = $this->getRole();
        return[''.$userRole.''];
    }
    public function getRole(): ?string
    {

        return $this->role;

    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    public function getSalt()
    {

    }

    public function eraseCredentials()
    {

    }
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password

        ]);
    }
    public function unserialize($string)
    {
            list(
            $this->id,
            $this->username,
            $this->password)=unserialize($string,['allowed_classes' =>false]);
    }
}
