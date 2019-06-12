<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigurationRepository")
 * @ORM\Table(name="configuration")
 */
class Configuration
{
    /**
     * @var integer
     *
     * @ORM\Column(name="configuration_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $configurationId;

    /**
     * @var string
     *
     * @ORM\Column(name="base_os", type="string", length=255, nullable=false)
     */
    private $base_os;

    /**
     * @var string
     *
     * @ORM\Column(name="family_os", type="string", length=255, nullable=false)
     */
    public $family_os;

    /**
     * Get configurationId
     *
     * @return integer
     */
    public function getConfigurationId()
    {
        return $this->configurationId;
    }

    /**
     * Set baseOs
     *
     * @param string $baseOs
     *
     * @return Configuration
     */
    public function setBaseOs($baseOs)
    {
        $this->base_os = $baseOs;

        return $this;
    }

    /**
     * Get baseOs
     *
     * @return string
     */
    public function getBaseOs()
    {
        return $this->base_os;
    }

    /**
     * Set familyOs
     *
     * @param string $familyOs
     *
     * @return Configuration
     */
    public function setFamilyOs($familyOs)
    {
        $this->family_os = $familyOs;

        return $this;
    }

    /**
     * Get familyOs
     *
     * @return string
     */
    public function getFamilyOs()
    {
        return $this->family_os;
    }
}
