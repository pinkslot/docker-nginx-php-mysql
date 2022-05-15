<?php

namespace App\Acme\Entity\Prize;

use App\Acme\Entity\User;
use App\Acme\Repository\MoneyPrizeRepository\MoneyPrizeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoneyPrizeRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"user_id"})
 * })
 */
class MoneyPrize implements PrizeInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private User $user;

    /**
     * @ORM\Column(type="integer")
     */
    private int $amount;

    public function __construct(User $user, int $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
