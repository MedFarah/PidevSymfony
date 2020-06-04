<?php

namespace LivraisonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\NotifiableInterface;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Livraison
 *
 * @ORM\Table(name="livraison")
 * @ORM\Entity(repositoryClass="LivraisonBundle\Repository\LivraisonRepository")
 */
class Livraison implements NotifiableInterface
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
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=20)
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;
    /**
     * @var string
     * @Assert\Length(max=10)
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat = "en cours";
    /**
     * @var string
     * @Assert\Length(min=8, max=80)
     * @Assert\NotBlank()
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="dateCreation", type="datetime")
     *  @Assert\DateTime()
     */
    private $dateCreation;
    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="dateLivraison", type="datetime", nullable=true)
     */
    private $dateLivraison;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="float")
     * @Assert\NotBlank()
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     *   @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     * )
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=8)
     */
    private $tel;

    /**
     * @ORM\ManyToOne(targetEntity="LivraisonBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $agent;
    /**
     * @ORM\ManyToOne(targetEntity="LivraisonBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $client;

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

    public function setClient(User $user)
    {
        $this->client = $user;
        return $this;
    }

    public function getClient()
    {
        return $this->client;
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
     * Set Id
     *
     * @param string $titre
     *
     * @return Livraison
     */
    public function setId($titre)
    {
        $this->id = $titre;
        return $this;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Livraison
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
     * Set etat
     *
     * @param string $etat
     *
     * @return Livraison
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Livraison
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

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
    public function getDateLivraisonn()
    {
        return $this->dateLivraison;
    }

    /**
     * @return \DateTime
     */
    /**
     * Set prix
     *
     * @param \DateTime $date
     *
     * @return Livraison
     */
    public function setDateLivraisonn($date)
    {
        $this->dateLivraison = $date;
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Livraison
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return int
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Livraison
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
