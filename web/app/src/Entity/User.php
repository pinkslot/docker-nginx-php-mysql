<?php

namespace App\Acme\Entity;

use App\Acme\Repository\UserRepository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $username;

    /**
     * @ORM\Column(type="string")
     */
    private string $passwordHash;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->passwordHash = password_hash($password, null);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }
}
