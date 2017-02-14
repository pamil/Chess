<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Application\Command;

use Pamil\Chess\Match\Domain\Model\PlayerId;

final class CreateMatch
{
    /** @var PlayerId */
    private $whitePlayerId;

    /** @var PlayerId */
    private $blackPlayerId;

    private function __construct(PlayerId $whitePlayerId, PlayerId $blackPlayerId)
    {
        $this->whitePlayerId = $whitePlayerId;
        $this->blackPlayerId = $blackPlayerId;
    }

    public static function betweenPlayers(PlayerId $whitePlayerId, PlayerId $blackPlayerId): self
    {
        return new self($whitePlayerId, $blackPlayerId);
    }

    public function whitePlayerId(): PlayerId
    {
        return $this->whitePlayerId;
    }

    public function blackPlayerId(): PlayerId
    {
        return $this->blackPlayerId;
    }
}
