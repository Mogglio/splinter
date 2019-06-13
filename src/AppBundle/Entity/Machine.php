<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MachineRepository")
 * @ORM\Table(name="machine")
 */
class Machine
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;


    /**
     * Get id
     *
     * @return integer
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Machine
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
