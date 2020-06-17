<?php

namespace CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\commandeRepository")
 */
class commande
{


    /**
     * @var string
     *@Assert\NotBlank
     * @Assert\Length(max=8)
     * @ORM\Column(name="ref_cmd", type="string", length=760)
     * @ORM\Id
     */
    private $refCmd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_cmd", type="date")
     */
    private $dateCmd;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_cmd", type="string", length=1000)
     */
    private $etatCmd;

    /**
     * @var float
     * * @Assert\NotBlank
     * @Assert\Length(min=5)
     *
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     *
     *
     * @ORM\Column(name="prix_cmd", type="float")
     */
    private $prixCmd;

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="CommandeBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ref_user", referencedColumnName="id")
     * })
     */
    private $idUser;





    /**
     * Set refCmd
     *
     * @param string $refCmd
     *
     * @return commande
     */
    public function setRefCmd($refCmd)
    {
        $this->refCmd = $refCmd;

        return $this;
    }

    /**
     * Get refCmd
     *
     * @return string
     */
    public function getRefCmd()
    {
        return $this->refCmd;
    }

    /**
     * Set dateCmd
     *
     * @param \DateTime $dateCmd
     *
     * @return commande
     */
    public function setDateCmd($dateCmd)
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    /**
     * Get dateCmd
     *
     * @return \DateTime
     */
    public function getDateCmd()
    {
        return $this->dateCmd;
    }

    /**
     * Set etatCmd
     *
     * @param string $etatCmd
     *
     * @return commande
     */
    public function setEtatCmd($etatCmd)
    {
        $this->etatCmd = $etatCmd;

        return $this;
    }

    /**
     * Get etatCmd
     *
     * @return string
     */
    public function getEtatCmd()
    {
        return $this->etatCmd;
    }

    /**
     * Set prixCmd
     *
     * @param float $prixCmd
     *
     * @return commande
     */
    public function setPrixCmd($prixCmd)
    {
        $this->prixCmd = $prixCmd;

        return $this;
    }

    /**
     * Get prixCmd
     *
     * @return float
     */
    public function getPrixCmd()
    {
        return $this->prixCmd;
    }




}

