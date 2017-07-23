<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaintenanceHistory
 *
 * @ORM\Table(name="maintenance_history")
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\MaintenanceHistory")
 */
class MaintenanceHistory
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
     * @var \Core\Entity\Car
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\Car")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="car_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $car;

    /**
     * @var \Core\Entity\MaintenanceRule
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\MaintenanceRule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="maintenance_rule_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $maintenanceRule;


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
     * @return MaintenanceHistory
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
     * Set car
     *
     * @param \Core\Entity\Car $car
     *
     * @return MaintenanceHistory
     */
    public function setCar(\Core\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \Core\Entity\Car
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Set maintenanceRule
     *
     * @param \Core\Entity\MaintenanceRule $maintenanceRule
     *
     * @return MaintenanceHistory
     */
    public function setMaintenanceRule(\Core\Entity\MaintenanceRule $maintenanceRule = null)
    {
        $this->maintenanceRule = $maintenanceRule;

        return $this;
    }

    /**
     * Get maintenanceRule
     *
     * @return \Core\Entity\MaintenanceRule
     */
    public function getMaintenanceRule()
    {
        return $this->maintenanceRule;
    }
}
