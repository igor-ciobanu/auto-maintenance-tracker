<?php

namespace Core\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CarType
 *
 * @ORM\Entity
 * @ORM\Table(name="car_type")
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\CarType")
 */
class CarType
{
    public function __construct()
    {
        $this->maintenanceRules = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\MaintenanceRule", mappedBy="carType")
     */
    private $maintenanceRules;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return CarType
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

    /**
     * @return mixed
     */
    public function getMaintenanceRules()
    {
        return $this->maintenanceRules;
    }
}
