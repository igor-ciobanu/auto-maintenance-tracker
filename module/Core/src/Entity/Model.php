<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="model", indexes={@ORM\Index(name="index2", columns={"mark_id"})})
 * @ORM\Entity(repositoryClass="Core\Entity\Repository\Model")
 */
class Model
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
     * @ORM\Column(name="name", type="string", length=45, precision=0, scale=0, nullable=false, unique=false)
     */
    private $name;

    /**
     * @var \Core\Entity\Mark
     *
     * @ORM\ManyToOne(targetEntity="Core\Entity\Mark")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mark_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $mark;


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
     * Set name
     *
     * @param string $name
     *
     * @return Model
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mark
     *
     * @param \Core\Entity\Mark $mark
     *
     * @return Model
     */
    public function setMark(\Core\Entity\Mark $mark = null)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return \Core\Entity\Mark
     */
    public function getMark()
    {
        return $this->mark;
    }
}
