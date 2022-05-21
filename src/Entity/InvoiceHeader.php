<?php

namespace App\Entity;

use App\Repository\InvoiceHeaderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceHeaderRepository::class)]
class InvoiceHeader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $nr;

    #[ORM\Column(type: 'date')]
    private $sellingDate;

    #[ORM\Column(type: 'date')]
    private $postingDate;

    #[ORM\ManyToOne(targetEntity: PaymentCodes::class, inversedBy: 'invoiceHeaders')]
    #[ORM\JoinColumn(nullable: false)]
    private $paymentCode;

    #[ORM\OneToMany(mappedBy: 'invoiceId', targetEntity: InvoiceLines::class)]
    private $invoiceLines;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'invoiceHeaders')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Clients::class, inversedBy: 'InvoiceHeadersSellTo')]
    private $sellTo;

    #[ORM\ManyToOne(targetEntity: Clients::class, inversedBy: 'InvoiceHeadersSellFrom')]
    private $SellFrom;

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
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNr(): ?string
    {
        return $this->nr;
    }

    public function setNr(string $nr): self
    {
        $this->nr = $nr;

        return $this;
    }

    public function getSellingDate(): ?\DateTimeInterface
    {
        return $this->sellingDate;
    }

    public function setSellingDate(\DateTimeInterface $sellingDate): self
    {
        $this->sellingDate = $sellingDate;

        return $this;
    }

    public function getPostingDate(): ?\DateTimeInterface
    {
        return $this->postingDate;
    }

    public function setPostingDate(\DateTimeInterface $postingDate): self
    {
        $this->postingDate = $postingDate;

        return $this;
    }

    public function getPaymentCode(): ?PaymentCodes
    {
        return $this->paymentCode;
    }

    public function setPaymentCode(?PaymentCodes $paymentCode): self
    {
        $this->paymentCode = $paymentCode;

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
            $invoiceLine->setInvoiceId($this);
        }

        return $this;
    }

    public function removeInvoiceLine(InvoiceLines $invoiceLine): self
    {
        if ($this->invoiceLines->removeElement($invoiceLine)) {
            // set the owning side to null (unless already changed)
            if ($invoiceLine->getInvoiceId() === $this) {
                $invoiceLine->setInvoiceId(null);
            }
        }

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

    /**
     * @return Collection<int, Clients>
     */


    public function getSellTo(): ?Clients
    {
        return $this->sellTo;
    }

    public function setSellTo(?Clients $sellTo): self
    {
        $this->sellTo = $sellTo;

        return $this;
    }

    public function getSellFrom(): ?Clients
    {
        return $this->SellFrom;
    }

    public function setSellFrom(?Clients $SellFrom): self
    {
        $this->SellFrom = $SellFrom;

        return $this;
    }

}
