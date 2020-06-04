<?php

namespace LivraisonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use http\Client\Curl\User;

/**
 * participants
 *
 * @ORM\Table(name="participants")
 * @ORM\Entity(repositoryClass="LivraisonBundle\Repository\participantsRepository")
 */


class participants
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var evenements
     *
     * @ORM\ManyToOne(targetEntity="LivraisonBundle\Entity\evenements", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEvenements", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * })
     */
    private $idEvenements;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }



    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->iduser;
    }

    /**
     * @return string
     */
    public function getIdEvenements()
    {
        return $this->idEvenements;
    }

    /**
     * @param string $idEvenements
     */
    public function setIdEvenements($idEvenements)
    {
        $this->idEvenements = $idEvenements;
    }


}


