<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Match\Domain\Model;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Pamil\Chess\Match\Domain\Event\MatchCreated;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Model\PlayerId;

final class MatchTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return Match::class;
    }

    /** @test */
    public function it_can_be_created_between_players(): void
    {
        $matchId = MatchId::generate();
        $whitePlayerId = PlayerId::fromString('Krawczyk');
        $blackPlayerId = PlayerId::fromString('Rynkowski');

        $this->scenario
            ->when(function () use ($matchId, $whitePlayerId, $blackPlayerId) {
                return Match::create($matchId, $whitePlayerId, $blackPlayerId);
            })
            ->then([
                MatchCreated::betweenPlayers($matchId, $whitePlayerId, $blackPlayerId),
            ])
        ;
    }
}
