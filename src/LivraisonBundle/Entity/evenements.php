<?php

namespace LivraisonBundle\Entity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * evenements
 *
 * @ORM\Table(name="evenements")
 * @ORM\Entity(repositoryClass="LivraisonBundle\Repository\evenementsRepository")
 * @Vich\Uploadable
 */
class evenements
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
     * @ORM\Column(name="nom_evenements", type="string", length=255)
     */
    private $nom_evenements;



    /**
     * @var int
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateeve", type="date")
     */
    private $dateeve;

    /**
     * @var string
     *
     * @ORM\Column(name="datedebut", type="time", length=255,nullable=true)
     */
    protected $datedebut;
    /**
     * @var string
     *
     * @ORM\Column(name="datefin", type="time", length=255,nullable=true)
     * @Assert\Expression(
     *     "this.getDateDebut() < this.getDateFin()",
     *     message="La date fin ne doit pas être antérieure à la date début"
     * )
     */
    protected $datefin;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=20)
     * @ORM\Column(name="lieuxeve", type="string", length=255)
     */
    private $lieuxeve;


    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=20)
     * @ORM\Column(name="descreptioneve", type="string", length=255)
     */
    private $descreptioneve;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNomEvenements()
    {
        return $this->nom_evenements;
    }

    /**
     * @param string $nom_evenements
     */
    public function setNomEvenements($nom_evenements)
    {
        $this->nom_evenements = $nom_evenements;
    }

    /**
     * @return int
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param int $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return \DateTime
     */
    public function getDateeve()
    {
        return $this->dateeve;
    }

    /**
     * @param \DateTime $dateeve
     */
    public function setDateeve($dateeve)
    {
        $this->dateeve = $dateeve;
    }

    /**
     * @return string
     */
    public function getLieuxeve()
    {
        return $this->lieuxeve;
    }

    /**
     * @param string $lieuxeve
     */
    public function setLieuxeve($lieuxeve)
    {
        $this->lieuxeve = $lieuxeve;
    }

    /**
     * @return string
     */
    public function getDescreptioneve()
    {
        return $this->descreptioneve;
    }

    /**
     * @param string $descreptioneve
     */
    public function setDescreptioneve($descreptioneve)
    {
        $this->descreptioneve = $descreptioneve;
    }

    /**
     * @return string
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param string $datedebut
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return string
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param string $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    }



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="paquet", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    // ...

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }


}



