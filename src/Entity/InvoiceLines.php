<?php

namespace App\Entity;

use App\Repository\InvoiceLinesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceLinesRepository::class)]
class InvoiceLines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $quantity;

    #[ORM\Column(type: 'float')]
    private $discount;

    #[ORM\ManyToOne(targetEntity: Products::class, inversedBy: 'invoiceLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $productId;

    #[ORM\ManyToOne(targetEntity: InvoiceHeader::class, inversedBy: 'invoiceLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $invoiceId;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'invoiceLines')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'string', length: 255)]
    private $productType;

    #[ORM\Column(type: 'string', length: 255)]
    private $productName;

    #[ORM\Column(type: 'float')]
    private $productVAT;

    #[ORM\Column(type: 'boolean')]
    private $productMppRelevant;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $productEAN;

    #[ORM\Column(type: 'string', length: 1023, nullable: true)]
    private $productDescription;

    #[ORM\Column(type: 'string', length: 255)]
    private $productUnit;

    #[ORM\Column(type: 'float')]
    private $productPrice;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getProductId(): ?Products
    {
        return $this->productId;
    }

    public function setProductId(?Products $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getInvoiceId(): ?InvoiceHeader
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(?InvoiceHeader $invoiceId): self
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): self
    {
        $this->productType = $productType;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductVAT(): ?float
    {
        return $this->productVAT;
    }

    public function setProductVAT(float $productVAT): self
    {
        $this->productVAT = $productVAT;

        return $this;
    }

    public function isProductMppRelevant(): ?bool
    {
        return $this->productMppRelevant;
    }

    public function setProductMppRelevant(bool $productMppRelevant): self
    {
        $this->productMppRelevant = $productMppRelevant;

        return $this;
    }

    public function getProductEAN(): ?int
    {
        return $this->productEAN;
    }

    public function setProductEAN(?int $productEAN): self
    {
        $this->productEAN = $productEAN;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(?string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductUnit(): ?string
    {
        return $this->productUnit;
    }

    public function setProductUnit(string $productUnit): self
    {
        $this->productUnit = $productUnit;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }
}
