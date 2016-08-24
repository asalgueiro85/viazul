<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuracion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Configuracion
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
     * @var float
     *
     * @ORM\Column(name="cuenta", type="float")
     */
    private $cuenta;

    /**
     * @var float
     *
     * @ORM\Column(name="fondo", type="float")
     */
    private $fondo;

    /**
     * @var float
     *
     * @ORM\Column(name="trans", type="float", nullable = true)
     */
    private $trans;



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
     * Set cuenta
     *
     * @param float $cuenta
     *
     * @return Configuracion
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return float
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set fondo
     *
     * @param float $fondo
     *
     * @return Configuracion
     */
    public function setFondo($fondo)
    {
        $this->fondo = $fondo;

        return $this;
    }

    /**
     * Get fondo
     *
     * @return float
     */
    public function getFondo()
    {
        return $this->fondo;
    }

    /**
     * Set trans
     *
     * @param float $trans
     *
     * @return Configuracion
     */
    public function setTrans($trans)
    {
        $this->trans = $trans;

        return $this;
    }

    /**
     * Get trans
     *
     * @return float
     */
    public function getTrans()
    {
        return $this->trans;
    }
}
