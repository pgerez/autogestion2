<?php

namespace App\Entity;

use App\Repository\CertificadoFacturaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertificadoFacturaRepository::class)
 */
class CertificadoFactura
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     *
     * @ORM\ManyToOne(targetEntity=Factura::class)
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="factura_id", referencedColumnName="id_factura")
     * })
     */
    private $facturas;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Certificado::class)
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="certificado_id", referencedColumnName="id")
     * })
     */
    private $certificados;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacturas(): ?Factura
    {
        return $this->facturas;
    }

    public function setFacturas(?Factura $facturas): self
    {
        $this->facturas = $facturas;

        return $this;
    }

    public function getCertificados(): ?Certificado
    {
        return $this->certificados;
    }

    public function setCertificados(?Certificado $certificados): self
    {
        $this->certificados = $certificados;

        return $this;
    }
}
