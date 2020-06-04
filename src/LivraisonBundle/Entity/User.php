<?php

namespace LivraisonBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="LivraisonBundle\Repository\UserRepository")
 */

class User  extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;

    
    /**
     * @var string
     *
     * @ORM\Column(name="nomComplet", type="string", length=255)
     *   @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     * )
     * @Assert\Length(min=5, max=20)
     * @Assert\NotBlank()
     */

    public $nomComplet;

    /**
     * @var string
     * @Assert\Length(min=6, max=80)
     * @Assert\NotBlank()
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    public $adresse;
    /**
     * @var string
     * @Assert\NotBlank()
     *   @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     * )
     * @Assert\Length(min=8, max=8)
     * @ORM\Column(name="tel", type="string", length=255)
     */

    private $tel;
    /**
     * @var \DateTime
     * @ORM\Column(name="dateCreation", type="datetime", length=255)
     * @Assert\DateTime()
     */
    private $dateCreation;
   

    public function __construct()
    {
        parent::__construct();
        $this->dateCreation = new \DateTime();
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
     * @param string $role
     */
    public function setPhoneNumber($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getNomComplet()
    {
        return $this->nomComplet;
    }

    /**
     * @param string n
     */
    public function setNomComplet($n)
    {
         $this->nomComplet = $n;
    }

    

    /**
     * @return string
     */
    public function getAdress()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function gettel()
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

  /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
  
    


}
