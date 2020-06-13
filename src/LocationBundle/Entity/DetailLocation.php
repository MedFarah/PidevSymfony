<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * DetailLocation
 *
 * @ORM\Table(name="detail_location", indexes={@ORM\Index(name="id_type", columns={"id_type"}), @ORM\Index(name="id_site", columns={"id_site"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class DetailLocation
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;

    /**
     * @var \Site
     *
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_site", referencedColumnName="id")
     * })
     */
    private $id_site;

    /**
     * @var \Type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     * })
     */
    private $id_type;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $id_user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \Site
     */
    public function getIdSite()
    {
        return $this->id_site;
    }

    /**
     * @param \Site $id_site
     */
    public function setIdSite($id_site)
    {
        $this->id_site = $id_site;
    }

    /**
     * @return \Type
     */
    public function getIdType()
    {
        return $this->id_type;
    }

    /**
     * @param \Type $id_type
     */
    public function setIdType($id_type)
    {
        $this->id_type = $id_type;
    }

    /**
     * @return \User
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param \User $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }



}

