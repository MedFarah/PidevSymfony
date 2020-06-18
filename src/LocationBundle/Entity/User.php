<?php

namespace LocationBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
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
     * @var integer
     *
     * @ORM\Column(name="numero_site", type="integer", nullable=true)
     */
    private $numero_site;

    /**
     * @return int
     */
    public function getNumeroSite()
    {
        return $this->numero_site;
    }

    /**
     * @param int $numero_site
     */
    public function setNumeroSite($numero_site)
    {
        $this->numero_site = $numero_site;
    }


}

