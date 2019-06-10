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
     * @ORM\Column(name="version_os", type="string", length=256, nullable=true)
     */
    private $versionOs;

    /**
     * @var string
     *
     * @ORM\Column(name="packages", type="text", length=65535, nullable=true)
     */
    private $packages;



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
     * Set versionOs
     *
     * @param $versionOs
     * @return Server
     */
    public function setVersionOs($versionOs)
    {
        $this->versionOs = $versionOs;

        return $this;
    }

    /**
     * Get versionOs
     *
     * @return string
     */
    public function getVersionOs()
    {
        return $this->versionOs;
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
}
