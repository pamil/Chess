<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Application\CommandHandler;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Pamil\Chess\Match\Application\Command\CreateMatch;
use Pamil\Chess\Match\Application\CommandHandler\CreateMatchHandler;
use Pamil\Chess\Match\Domain\Event\MatchCreated;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Model\PlayerId;
use Pamil\Chess\Match\Infrastructure\Repository\BroadwayMatchRepository;

final class CreateMatchHandlerTest extends CommandHandlerScenarioTestCase
{
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus): CommandHandlerInterface
    {
        $matchRepository = new BroadwayMatchRepository(new EventSourcingRepository(
            $eventStore,
            $eventBus,
            Match::class,
            new ReflectionAggregateFactory()
        ));

        return new CreateMatchHandler($matchRepository);
    }

    /** @test */
    public function it_creates_a_match_between_players()
    {
        $matchId = MatchId::generate();
        $whitePlayerId = PlayerId::fromString('Krawczyk');
        $blackPlayerId = PlayerId::fromString('Rynkowski');

        $this->scenario
            ->withAggregateId($matchId->toString())
            ->given([])
            ->when(CreateMatch::betweenPlayers($matchId, $whitePlayerId, $blackPlayerId))
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
    public function it_cannot_create_a_match_with_single_player(): void
    {
        $matchId = MatchId::generate();
        $playerId = PlayerId::fromString('Cheater');

        $this->scenario
            ->when(Match::create($matchId, $playerId, $playerId))
        ;
    }
}
