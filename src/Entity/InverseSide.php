<?php

declare(strict_types=1);

/*
 * This file is part of the zenstruck/foundry package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Nicolas PHILIPPE <nikophil@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table('one_to_one_with_owning_entity_as_id_inverse_side')]
class InverseSide
{
    #[ORM\Column(type: Types::STRING)]
    private string $status = 'created';

    public function __construct(
        #[ORM\Id]
        #[ORM\OneToOne(targetEntity: OwningSide::class, inversedBy: 'inverseSide')]
        #[ORM\JoinColumn(name: 'owning_side_id', referencedColumnName: 'id')]
        private OwningSide $owningSide,
    ) {
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getOwningSide(): OwningSide
    {
        return $this->owningSide;
    }

    public function setOwningSide(OwningSide $owningSide): void
    {
        $this->owningSide = $owningSide;
        $owningSide->inverseSide = $this;
    }
}
