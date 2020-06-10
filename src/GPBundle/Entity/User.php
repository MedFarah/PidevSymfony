<?php

namespace GPBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */

class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="nomComplet", type="string", length=255)
     */

    public $nomComplet;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    public $adresse;
    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     */

    private $tel;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", length=255)
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