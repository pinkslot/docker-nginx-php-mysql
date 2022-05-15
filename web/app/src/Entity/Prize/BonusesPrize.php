<?php

namespace App\Acme\Entity\Prize;

use App\Acme\Entity\User;
use App\Acme\Repository\BonusesPrizeRepository\BonusesPrizeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BonusesPrizeRepository::class)
 * @ORM\Table(indexes={
 *     @ORM\Index(columns={"user_id"})
 * })
 */
class BonusesPrize implements PrizeInterface
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
