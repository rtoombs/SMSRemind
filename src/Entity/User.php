<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        // $this->salt = md5(uniqid('', true));
    }

    public function getId(){ return $this->id; }

    public function getUsername(){ return $this->username; }

    public function setUsername($name){ $this->username = $name; }

    public function getEmail(){ return $this->email; }

    public function setEmail($email){ $this->email = $email; }

    public function getSalt(){ return null; }

    public function getActive(){ return $this->isActive; }

    public function setActive($active){ $this->isActive = $active; }

    public function setPassword($pass){ $this->password = $pass; }

    public function getPassword(){ return $this->password; }

    public function getRoles(){ return array('ROLE_USER'); }

    public function eraseCredentials()
    {
        //TODO when needed
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // $this->salt
            ) = unserialize($serialized);
    }
}
