<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID, unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $job_id = null;

    #[ORM\Column(
        name: 'job_type',
        type: Types::STRING,
        nullable: false,
        enumType: JobType::class,
        columnDefinition: "job_type_enum"
    )]
    private ?JobType $job_type = null;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(referencedColumnName: "customer_id", nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(referencedColumnName: "site_id", nullable: false)]
    private ?Site $site = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $due_by = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $completed_at = null;

    #[ORM\Column]
    private ?bool $late = null;

    #[ORM\Column]
    private ?bool $flagged = null;

    #[ORM\Column]
    private ?int $number_of_items = null;
    public function getJobId(): ?string
    {
        return $this->job_id;
    }

    public function setJobId(string $job_id): self
    {
        $this->job_id = $job_id;

        return $this;
    }

    /**
     * @param JobType|null $job_type
     */
    public function setJobType(?JobType $job_type): void
    {
        $this->job_type = $job_type;
    }

    /**
     * @return JobType|null
     */
    public function getJobType(): ?JobType
    {
        return $this->job_type;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getDueBy(): ?\DateTimeImmutable
    {
        return $this->due_by;
    }

    public function setDueBy(\DateTimeImmutable $due_by): self
    {
        $this->due_by = $due_by;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completed_at;
    }

    public function setCompletedAt(?\DateTimeImmutable $completed_at): self
    {
        $this->completed_at = $completed_at;

        return $this;
    }

    public function isLate(): ?bool
    {
        return $this->late;
    }

    public function setLate(bool $late): self
    {
        $this->late = $late;

        return $this;
    }

    public function isFlagged(): ?bool
    {
        return $this->flagged;
    }

    public function setFlagged(bool $flagged): self
    {
        $this->flagged = $flagged;

        return $this;
    }

    public function getNumberOfItems(): ?int
    {
        return $this->number_of_items;
    }

    public function setNumberOfItems(int $number_of_items): self
    {
        $this->number_of_items = $number_of_items;

        return $this;
    }
}
