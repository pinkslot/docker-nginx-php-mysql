<?php

namespace App\Acme\Entity;

use App\Acme\Repository\MoneyDepositRepository\MoneyDepositRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoneyDepositRepository::class)
 */
class MoneyDeposit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }
}
