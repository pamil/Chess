<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Match\Domain\Model;

use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Pamil\Chess\Match\Domain\Event\MatchCreated;
use Pamil\Chess\Match\Domain\Event\MatchFinished;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Model\MatchResult;
use Pamil\Chess\Match\Domain\Model\PlayerId;

final class MatchTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return Match::class;
    }

    protected function getAggregateRootFactory(): AggregateFactoryInterface
    {
        return new ReflectionAggregateFactory();
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

    /**
     * @test
     *
     * @expectedException \Pamil\Chess\Match\Domain\Exception\CannotCreateMatch
     */
    public function it_can_not_be_created_with_single_player(): void
    {
        $matchId = MatchId::generate();
        $playerId = PlayerId::fromString('Cheater');

        $this->scenario
            ->when(function () use ($matchId, $playerId) {
                return Match::create($matchId, $playerId, $playerId);
            })
        ;
    }

    /** @test */
    public function match_can_be_finished(): void
    {
        $matchId = MatchId::generate();
        $whitePlayerId = PlayerId::fromString('Krawczyk');
        $blackPlayerId = PlayerId::fromString('Rynkowski');

        $this->scenario
            ->withAggregateId($matchId->toString())
            ->given([
                MatchCreated::betweenPlayers($matchId, $whitePlayerId, $blackPlayerId   )
            ])
            ->when(function (Match $match) {
                $match->finish(MatchResult::whiteWon());
            })
            ->then([
                MatchFinished::withResult($matchId, MatchResult::whiteWon())
            ])
        ;
    }
}
