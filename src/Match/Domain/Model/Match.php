<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Pamil\Chess\Match\Domain\Event\MatchCreated;
use Pamil\Chess\Match\Domain\Exception\CannotCreateMatch;

final class Match extends EventSourcedAggregateRoot
{
    /**
     * @var MatchId
     */
    private $id;

    private function __construct()
    {

    }

    public static function create(PlayerId $whitePlayerId, PlayerId $blackPlayerId): self
    {
        if ($whitePlayerId->toString() === $blackPlayerId->toString()) {
            throw CannotCreateMatch::withSinglePlayer($whitePlayerId);
        }

        $match = new self();
        $match->apply(MatchCreated::betweenPlayers(MatchId::generate(), $whitePlayerId, $blackPlayerId));

        return $match;
    }

    public function applyMatchCreated(MatchCreated $event): void
    {
        $this->id = $event->matchId();
    }

    public function getAggregateRootId(): string
    {
        return $this->id->toString();
    }
}
