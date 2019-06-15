<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table(name="server")
 * @ORM\Entity
 */
class Server
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_server", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idServer;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="base_os", type="string", length=256, nullable=true)
     */
    private $baseOs;

    /**
     * @var string
     *
     * @ORM\Column(name="packages", type="text", length=65535, nullable=true)
     */
    private $packages;

    /**
     * @var string
     *
     * @ORM\Column(name="zone", type="string", length=256, nullable=true)
     */
    private $zone;



    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Server
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set baseOs
     *
     * @param string $baseOs
     *
     * @return Server
     */
    public function setBaseOs($baseOs)
    {
        $this->baseOs = $baseOs;

        return $this;
    }

    /**
     * Get baseOs
     *
     * @return string
     */
    public function getBaseOs()
    {
        return $this->baseOs;
    }

    /**
     * Set packages
     *
     * @param string $packages
     *
     * @return Server
     */
    public function setPackages($packages)
    {
        $this->packages = $packages;

        return $this;
    }

    /**
     * Get packages
     *
     * @return string
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * Get idServer
     *
     * @return integer
     */
    public function getIdServer()
    {
        return $this->idServer;
    }

    /**
     * Set zone
     *
     * @param string $zone
     *
     * @return Server
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
    }
}
