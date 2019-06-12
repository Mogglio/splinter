<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $username;

    protected $email;

    /**
     * Get username
     *
     * @return integer
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get email
     *
     * @return integer
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function __construct()
    {
        parent::__construct();

    }
}