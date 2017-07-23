<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaintenanceRule
 *
 * @ORM\Entity
 * @ORM\Table(name="maintenance_rule")
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\MaintenanceRule")
 */
class MaintenanceRule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="km", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $km;

    /**
     * @var \Core\Entity\CarType
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\CarType", inversedBy="maintenance_rule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="car_type_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $carType;

    /**
     * @var \Core\Entity\MaintenanceType
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\MaintenanceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="maintenance_type_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $maintenanceType;


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
     * Set km
     *
     * @param integer $km
     *
     * @return MaintenanceRule
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return integer
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set carType
     *
     * @param \Core\Entity\CarType $carType
     *
     * @return MaintenanceRule
     */
    public function setCarType(\Core\Entity\CarType $carType = null)
    {
        $this->carType = $carType;

        return $this;
    }

    /**
     * Get carType
     *
     * @return \Core\Entity\CarType
     */
    public function getCarType()
    {
        return $this->carType;
    }

    /**
     * Set maintenanceType
     *
     * @param \Core\Entity\MaintenanceType $maintenanceType
     *
     * @return MaintenanceRule
     */
    public function setMaintenanceType(\Core\Entity\MaintenanceType $maintenanceType = null)
    {
        $this->maintenanceType = $maintenanceType;

        return $this;
    }

    /**
     * Get maintenanceType
     *
     * @return \Core\Entity\MaintenanceType
     */
    public function getMaintenanceType()
    {
        return $this->maintenanceType;
    }
}
