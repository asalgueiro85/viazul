<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Causa
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CausaRepository")
 */
class Causa
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     *
     * @ORM\OneToMany(targetEntity="Bauche", mappedBy="causa", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $bauches;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Causa
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Causa
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    function __toString()
    {
        return $this->nombre;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bauches = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add bauch
     *
     * @param \AppBundle\Entity\Bauche $bauch
     *
     * @return Causa
     */
    public function addBauch(\AppBundle\Entity\Bauche $bauch)
    {
        $this->bauches[] = $bauch;

        return $this;
    }

    /**
     * Remove bauch
     *
     * @param \AppBundle\Entity\Bauche $bauch
     */
    public function removeBauch(\AppBundle\Entity\Bauche $bauch)
    {
        $this->bauches->removeElement($bauch);
    }

    /**
     * Get bauches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBauches()
    {
        return $this->bauches;
    }



}
