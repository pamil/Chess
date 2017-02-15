<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Application\Repository;

use Pamil\Chess\Player\Application\Exception\PlayerNotFound;
use Pamil\Chess\Player\Domain\Model\Player;
use Pamil\Chess\Player\Domain\Model\PlayerId;

interface PlayerRepository
{
    /**
     * @throws PlayerNotFound
     */
    public function get(PlayerId $playerId): Player;

    public function save(Player $player): void;
}
