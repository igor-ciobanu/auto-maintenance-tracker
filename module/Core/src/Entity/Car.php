<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\Car")
 */
class Car
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
     * @var string
     *
     * @ORM\Column(name="vin", type="string", length=10, precision=0, scale=0, nullable=false, unique=false)
     */
    private $vin;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="km", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $km;

    /**
     * @var \Core\Entity\CarType
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\CarType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="car_type_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $carType;

    /**
     * @var \Core\Entity\Model
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\Model")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="model_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\MaintenanceHistory", mappedBy="car", cascade={"persist"})
     */
    private $maintenanceHistories;


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
     * Set vin
     *
     * @param string $vin
     *
     * @return Car
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Car
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set km
     *
     * @param integer $km
     *
     * @return Car
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
     * @return Car
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
     * Set model
     *
     * @param \Core\Entity\Model $model
     *
     * @return Car
     */
    public function setModel(\Core\Entity\Model $model = null)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return \Core\Entity\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getMaintenanceHistories()
    {
        return $this->maintenanceHistories;
    }
}
