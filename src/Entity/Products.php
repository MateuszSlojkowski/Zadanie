<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Type;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'float')]
    private $vat;

    #[ORM\Column(type: 'boolean')]
    private $mppRelevant;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $ean;

    #[ORM\Column(type: 'string', length: 1023, nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $unit;

    #[ORM\OneToMany(mappedBy: 'productId', targetEntity: InvoiceLines::class)]
    private $invoiceLines;

    public function __construct()
    {
        $this->invoiceLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function isMppRelevant(): ?bool
    {
        return $this->mppRelevant;
    }

    public function setMppRelevant(bool $mppRelevant): self
    {
        $this->mppRelevant = $mppRelevant;

        return $this;
    }

    public function getEan(): ?int
    {
        return $this->ean;
    }

    public function setEan(?int $ean): self
    {
        $this->ean = $ean;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceLines>
     */
    public function getInvoiceLines(): Collection
    {
        return $this->invoiceLines;
    }

    public function addInvoiceLine(InvoiceLines $invoiceLine): self
    {
        if (!$this->invoiceLines->contains($invoiceLine)) {
            $this->invoiceLines[] = $invoiceLine;
            $invoiceLine->setProductId($this);
        }

        return $this;
    }

    public function removeInvoiceLine(InvoiceLines $invoiceLine): self
    {
        if ($this->invoiceLines->removeElement($invoiceLine)) {
            // set the owning side to null (unless already changed)
            if ($invoiceLine->getProductId() === $this) {
                $invoiceLine->setProductId(null);
            }
        }

        return $this;
    }

}
