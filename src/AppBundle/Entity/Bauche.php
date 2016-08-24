<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bauche
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BaucheRepository")
 */
class Bauche
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
     * @var integer
     *
     * @ORM\Column(name="codigo", type="integer")
     */
    private $codigo;

    /**
     * @var float
     *
     * @ORM\Column(name="importe", type="float")
     */
    private $importe;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;


    /**
     * @var string
     *
     * @ORM\Column(name="destino", type="string", length=255)
     */
    private $destino;

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="string", length=255)
     */
    private $area;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_area", type="string", length=255)
     */
    private $dirArea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_emitido", type="datetime")
     */
    private $fechaEmitido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_consumo", type="datetime", nullable = true)
     */
    private $fechaConsumo;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Causa", inversedBy="bauches")
     * @ORM\JoinColumn(name="causa_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $causa;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    function __construct()
    {
        $this->codigo = '50606';
    }


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
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return Bauche
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set importe
     *
     * @param float $importe
     *
     * @return Bauche
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Bauche
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
     * Set destino
     *
     * @param string $destino
     *
     * @return Bauche
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return string
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * Set area
     *
     * @param string $area
     *
     * @return Bauche
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set dirArea
     *
     * @param string $dirArea
     *
     * @return Bauche
     */
    public function setDirArea($dirArea)
    {
        $this->dirArea = $dirArea;

        return $this;
    }

    /**
     * Get dirArea
     *
     * @return string
     */
    public function getDirArea()
    {
        return $this->dirArea;
    }

    /**
     * Set fechaEmitido
     *
     * @param \DateTime $fechaEmitido
     *
     * @return Bauche
     */
    public function setFechaEmitido($fechaEmitido)
    {
        $this->fechaEmitido = $fechaEmitido;

        return $this;
    }

    /**
     * Get fechaEmitido
     *
     * @return \DateTime
     */
    public function getFechaEmitido()
    {
        return $this->fechaEmitido;
    }

    /**
     * Set fechaConsumo
     *
     * @param \DateTime $fechaConsumo
     *
     * @return Bauche
     */
    public function setFechaConsumo($fechaConsumo)
    {
        $this->fechaConsumo = $fechaConsumo;

        return $this;
    }

    /**
     * Get fechaConsumo
     *
     * @return \DateTime
     */
    public function getFechaConsumo()
    {
        return $this->fechaConsumo;
    }

    /**
     * @return boolean
     */
    public function isEstado()
    {
        return $this->estado;
    }

    /**
     * @param boolean $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set causa
     *
     * @param \AppBundle\Entity\Causa $causa
     *
     * @return Bauche
     */
    public function setCausa(\AppBundle\Entity\Causa $causa = null)
    {
        $this->causa = $causa;

        return $this;
    }

    /**
     * Get causa
     *
     * @return \AppBundle\Entity\Causa
     */
    public function getCausa()
    {
        return $this->causa;
    }
}
