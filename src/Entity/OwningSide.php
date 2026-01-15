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

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Nicolas PHILIPPE <nikophil@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table('inversed_one_to_one_with_owning_entity_as_id_owning_side')]
class OwningSide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', unique: true)]
    public ?int $id = null;

    #[ORM\OneToOne(targetEntity: InverseSide::class, mappedBy: 'owningSide')]
    public ?InverseSide $inverseSide = null;
}
