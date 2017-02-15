<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Event;

use Pamil\Chess\Player\Domain\Model\Elo;
use Pamil\Chess\Player\Domain\Model\PlayerId;

final class PlayerRated
{
    /** @var PlayerId */
    private $id;

    /** @var Elo */
    private $elo;

    public function __construct(PlayerId $id, Elo $elo)
    {
        $this->id = $id;
        $this->elo = $elo;
    }

    public function id(): PlayerId
    {
        return $this->id;
    }

    public function elo(): Elo
    {
        return $this->elo;
    }
}
