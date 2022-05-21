<?php

namespace App\Entity;

use App\Repository\PaymentCodesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentCodesRepository::class)]
class PaymentCodes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $code;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $due;

    #[ORM\OneToMany(mappedBy: 'paymentCode', targetEntity: InvoiceHeader::class)]
    private $invoiceHeaders;

    public function __construct()
    {
        $this->invoiceHeaders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDue(): ?int
    {
        return $this->due;
    }

    public function setDue(int $due): self
    {
        $this->due = $due;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceHeader>
     */
    public function getInvoiceHeaders(): Collection
    {
        return $this->invoiceHeaders;
    }

    public function addInvoiceHeader(InvoiceHeader $invoiceHeader): self
    {
        if (!$this->invoiceHeaders->contains($invoiceHeader)) {
            $this->invoiceHeaders[] = $invoiceHeader;
            $invoiceHeader->setPaymentCode($this);
        }

        return $this;
    }

    public function removeInvoiceHeader(InvoiceHeader $invoiceHeader): self
    {
        if ($this->invoiceHeaders->removeElement($invoiceHeader)) {
            // set the owning side to null (unless already changed)
            if ($invoiceHeader->getPaymentCode() === $this) {
                $invoiceHeader->setPaymentCode(null);
            }
        }

        return $this;
    }
}
