<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Retours
 *
 * @ORM\Table(name="retours", indexes={@ORM\Index(name="id_location", columns={"id_location"})})
 * @ORM\Entity
 */
class Retours
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean", nullable=false)
     */
    private $etat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="retard", type="boolean", nullable=false)
     */
    private $retard;

    /**
     * @var \DetailLocation
     *
     * @ORM\ManyToOne(targetEntity="DetailLocation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_location", referencedColumnName="id")
     * })
     */
    private $idLocation;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return bool
     */
    public function isEtat()
    {
        return $this->etat;
    }

    /**
     * @param bool $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return bool
     */
    public function isRetard()
    {
        return $this->retard;
    }

    /**
     * @param bool $retard
     */
    public function setRetard($retard)
    {
        $this->retard = $retard;
    }

    /**
     * @return \DetailLocation
     */
    public function getIdLocation()
    {
        return $this->idLocation;
    }

    /**
     * @param \DetailLocation $idLocation
     */
    public function setIdLocation($idLocation)
    {
        $this->idLocation = $idLocation;
    }



}

