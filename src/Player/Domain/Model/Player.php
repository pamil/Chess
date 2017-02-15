<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Pamil\Chess\Player\Domain\Event\PlayerRated;
use Pamil\Chess\Player\Domain\Event\PlayerRegistered;

final class Player extends EventSourcedAggregateRoot
{
    /** @var PlayerId */
    private $id;

    private function __construct()
    {

    }

    public static function register(PlayerId $playerId): self
    {
        $player = new self();
        $player->apply(new PlayerRegistered($playerId));
        $player->apply(new PlayerRated($playerId, new Elo(1200)));

        return $player;
    }

    public function id(): PlayerId
    {
        return $this->id;
    }

    public function getAggregateRootId(): string
    {
        return $this->id()->toString();
    }

    protected function applyPlayerRegistered(PlayerRegistered $event): void
    {
        $this->id = $event->id();
    }
}
