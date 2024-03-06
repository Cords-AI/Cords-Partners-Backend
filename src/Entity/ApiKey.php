<?php

namespace App\Entity;

use App\Repository\ApiKeyRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: ApiKeyRepository::class)]
class ApiKey implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $apiKey = null;

    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    #[ORM\Column(nullable: true)]
    private ?bool $deleted = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function jsonSerialize(): mixed {
        return [
            "id" => $this->id,
            "uid" => $this->uid,
            "apiKey" => $this->apiKey
        ];
    }
}
