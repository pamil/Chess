<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Event;

use Pamil\Chess\Player\Domain\Model\PlayerId;

final class PlayerRegistered
{
    /** @var PlayerId */
    private $id;

    public function __construct(PlayerId $id)
    {
        $this->id = $id;
    }

    public function id(): PlayerId
    {
        return $this->id;
    }
}
