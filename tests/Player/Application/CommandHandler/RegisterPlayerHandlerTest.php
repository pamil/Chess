<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Application\CommandHandler;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use Pamil\Chess\Player\Application\Command\RegisterPlayer;
use Pamil\Chess\Player\Application\CommandHandler\RegisterPlayerHandler;
use Pamil\Chess\Player\Domain\Event\PlayerRated;
use Pamil\Chess\Player\Domain\Event\PlayerRegistered;
use Pamil\Chess\Player\Domain\Model\Elo;
use Pamil\Chess\Player\Domain\Model\Player;
use Pamil\Chess\Player\Domain\Model\PlayerId;
use Pamil\Chess\Player\Infrastructure\Repository\BroadwayPlayerRepository;

final class RegisterPlayerHandlerTest extends CommandHandlerScenarioTestCase
{
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus): CommandHandlerInterface
    {
        $playerRepository = new BroadwayPlayerRepository(new EventSourcingRepository(
            $eventStore,
            $eventBus,
            Player::class,
            new ReflectionAggregateFactory()
        ));

        return new RegisterPlayerHandler($playerRepository);
    }

    /** @test */
    public function it_registers_a_player(): void
    {
        $playerId = PlayerId::fromString('Elon Musk');

        $this->scenario
            ->withAggregateId($playerId->toString())
            ->given([])
            ->when(new RegisterPlayer($playerId))
            ->then([
                new PlayerRegistered($playerId),
                new PlayerRated($playerId, new Elo(1200)),
            ])
        ;
    }
}
