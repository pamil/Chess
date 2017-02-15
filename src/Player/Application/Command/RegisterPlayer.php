<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Application\Command;

use Pamil\Chess\Player\Domain\Model\PlayerId;

final class RegisterPlayer
{
    /** @var PlayerId */
    private $playerId;

    private function __construct(PlayerId $playerId)
    {
        $this->playerId = $playerId;
    }

    public static function withId(PlayerId $playerId): self
    {
        return new self($playerId);
    }

    public function id(): PlayerId
    {
        return $this->playerId;
    }
}
