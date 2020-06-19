<?php

namespace MaintenanceBundle\Entity;

use FOS\UserBundle\Model\User as BaseUSer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`fos_user`")
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nomComplet", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=20, nullable=false)
     */
    private $numtel;

    /**
     * @return string
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param string $numtel
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;
    }

}

