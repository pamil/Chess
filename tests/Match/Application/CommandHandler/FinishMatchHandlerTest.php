<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Application\CommandHandler;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Pamil\Chess\Match\Application\Command\FinishMatch;
use Pamil\Chess\Match\Application\CommandHandler\FinishMatchHandler;
use Pamil\Chess\Match\Domain\Event\MatchCreated;
use Pamil\Chess\Match\Domain\Event\MatchFinished;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Model\MatchResult;
use Pamil\Chess\Match\Domain\Model\PlayerId;
use Pamil\Chess\Match\Infrastructure\Repository\BroadwayMatchRepository;

final class FinishMatchHandlerTest extends CommandHandlerScenarioTestCase
{
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus): CommandHandlerInterface
    {
        $matchRepository = new BroadwayMatchRepository(new EventSourcingRepository(
            $eventStore,
            $eventBus,
            Match::class,
            new ReflectionAggregateFactory()
        ));

        return new FinishMatchHandler($matchRepository);
    }

    /** @test */
    public function it_finishes_a_match()
    {
        $matchId = MatchId::generate();
        $whitePlayerId = PlayerId::fromString('Krawczyk');
        $blackPlayerId = PlayerId::fromString('Rynkowski');

        $this->scenario
            ->withAggregateId($matchId->toString())
            ->given([
                MatchCreated::betweenPlayers($matchId, $whitePlayerId, $blackPlayerId)
            ])
            ->when(FinishMatch::withResult($matchId, MatchResult::blackWon()))
            ->then([
                MatchFinished::withResult($matchId, MatchResult::blackWon()),
            ])
        ;
    }

    /**
     * @test
     *
     * @expectedException \Pamil\Chess\Match\Application\Exception\MatchNotFound
     */
    public function it_cannot_finish_an_unexisting_match()
    {
        $this->scenario
            ->when(FinishMatch::withResult(MatchId::generate(), MatchResult::draw()))
        ;
    }
}
