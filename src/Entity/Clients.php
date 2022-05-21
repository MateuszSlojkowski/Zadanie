<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $postCode;

    #[ORM\Column(type: 'string', length: 255)]
    private $city;

    #[ORM\Column(type: 'string', length: 255)]
    private $street;

    #[ORM\Column(type: 'string', length: 255)]
    private $nr; //street nr

    #[ORM\Column(type: 'integer')]
    private $phone;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $bankAccountNr;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $vatRegistrationNr;

    #[ORM\OneToMany(mappedBy: 'sellTo', targetEntity: InvoiceHeader::class)]
    private $InvoiceHeadersSellTo;

    #[ORM\OneToMany(mappedBy: 'SellFrom', targetEntity: InvoiceHeader::class)]
    private $InvoiceHeadersSellFrom;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $defoult;

    public function __construct()
    {
        $this->invoiceHeaders = new ArrayCollection();
        $this->InvoiceHeadersSellTo = new ArrayCollection();
        $this->InvoiceHeadersSellFrom = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBankAccountNr(): ?int
    {
        return $this->bankAccountNr;
    }

    public function setBankAccountNr(?int $bankAccountNr): self
    {
        $this->bankAccountNr = $bankAccountNr;

        return $this;
    }

    public function getVatRegistrationNr(): ?int
    {
        return $this->vatRegistrationNr;
    }

    public function setVatRegistrationNr(?int $vatRegistrationNr): self
    {
        $this->vatRegistrationNr = $vatRegistrationNr;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceHeader>
     */
    public function getInvoiceHeaders(): Collection
    {
        return $this->invoiceHeaders;
    }


    /**
     * @return Collection<int, InvoiceHeader>
     */
    public function getInvoiceHeadersSellTo(): Collection
    {
        return $this->InvoiceHeadersSellTo;
    }

    public function addInvoiceHeadersSellTo(InvoiceHeader $invoiceHeadersSellTo): self
    {
        if (!$this->InvoiceHeadersSellTo->contains($invoiceHeadersSellTo)) {
            $this->InvoiceHeadersSellTo[] = $invoiceHeadersSellTo;
            $invoiceHeadersSellTo->setSellTo($this);
        }

        return $this;
    }

    public function removeInvoiceHeadersSellTo(InvoiceHeader $invoiceHeadersSellTo): self
    {
        if ($this->InvoiceHeadersSellTo->removeElement($invoiceHeadersSellTo)) {
            // set the owning side to null (unless already changed)
            if ($invoiceHeadersSellTo->getSellTo() === $this) {
                $invoiceHeadersSellTo->setSellTo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InvoiceHeader>
     */
    public function getInvoiceHeadersSellFrom(): Collection
    {
        return $this->InvoiceHeadersSellFrom;
    }

    public function addInvoiceHeadersSellFrom(InvoiceHeader $invoiceHeadersSellFrom): self
    {
        if (!$this->InvoiceHeadersSellFrom->contains($invoiceHeadersSellFrom)) {
            $this->InvoiceHeadersSellFrom[] = $invoiceHeadersSellFrom;
            $invoiceHeadersSellFrom->setSellFrom($this);
        }

        return $this;
    }

    public function removeInvoiceHeadersSellFrom(InvoiceHeader $invoiceHeadersSellFrom): self
    {
        if ($this->InvoiceHeadersSellFrom->removeElement($invoiceHeadersSellFrom)) {
            // set the owning side to null (unless already changed)
            if ($invoiceHeadersSellFrom->getSellFrom() === $this) {
                $invoiceHeadersSellFrom->setSellFrom(null);
            }
        }

        return $this;
    }

    public function isDefoult(): ?bool
    {
        return $this->defoult;
    }

    public function setDefoult(?bool $defoult): self
    {
        $this->defoult = $defoult;

        return $this;
    }

}
