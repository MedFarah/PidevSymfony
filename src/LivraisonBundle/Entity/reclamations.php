<?php

namespace LivraisonBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * reclamation
 *
 * @ORM\Table(name="reclamations")
 * @ORM\Entity(repositoryClass="LivraisonBundle\Repository\reclamationsRepository")
 */
class reclamations
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     *  @Assert\DateTime()
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="LivraisonBundle\Entity\Livraison")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $livraison;

    /**
     * @ORM\ManyToOne(targetEntity="LivraisonBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $agent;




    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }


    public function setAgent(User $user)
    {
        $this->agent = $user;
        return $this;
    }

    public function getAgent()
    {
        return $this->agent;
    }

    public function setLivraison(Livraison $livr)
    {
        $this->livraison = $livr;
        return $this;
    }

    public function getLivraison()
    {
        return $this->livraison;
    }

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
     * Set titre
     *
     * @param string $titre
     *
     * @return reclamation
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     *
     * @return reclamation
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @return \DateTime
     */
    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }
}