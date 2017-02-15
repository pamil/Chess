<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Infrastructure\Repository;

use Pamil\Chess\Player\Application\Exception\PlayerNotFound;
use Pamil\Chess\Player\Domain\Model\Player;
use Pamil\Chess\Player\Domain\Model\PlayerId;
use Pamil\Chess\Player\Application\Repository\PlayerRepository;

final class ArrayPlayerRepository implements PlayerRepository
{
    /** @var Player[] Indexed by stringified PlayerId */
    private $matches = [];

    public function get(PlayerId $playerId): Player
    {
        if (!array_key_exists($playerId->toString(), $this->matches)) {
            throw PlayerNotFound::withId($playerId);
        }

        return $this->matches[$playerId->toString()];
    }

    public function save(Player $match): void
    {
        $this->matches[$match->id()->toString()] = $match;
    }
}
