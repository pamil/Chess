<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Model;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Pamil\Chess\Match\Domain\Event\MatchCreated;
use Pamil\Chess\Match\Domain\Event\MatchFinished;
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

    public static function create(MatchId $matchId, PlayerId $whitePlayerId, PlayerId $blackPlayerId): self
    {
        if ($whitePlayerId->toString() === $blackPlayerId->toString()) {
            throw CannotCreateMatch::withSinglePlayer($whitePlayerId);
        }

        $match = new self();
        $match->apply(MatchCreated::betweenPlayers($matchId, $whitePlayerId, $blackPlayerId));

        return $match;
    }

    public function finish(MatchResult $result): void
    {
        $this->apply(MatchFinished::withResult($this->id(), $result));
    }

    public function id(): MatchId
    {
        return $this->id;
    }

    public function getAggregateRootId(): string
    {
        return $this->id()->toString();
    }

    protected function applyMatchCreated(MatchCreated $event): void
    {
        $this->id = $event->matchId();
    }
}
