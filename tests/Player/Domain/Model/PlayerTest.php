<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Player\Domain\Model;

use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Pamil\Chess\Player\Domain\Event\PlayerRegistered;
use Pamil\Chess\Player\Domain\Model\Player;
use Pamil\Chess\Player\Domain\Model\PlayerId;

final class PlayerTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return Player::class;
    }

    protected function getAggregateRootFactory(): AggregateFactoryInterface
    {
        return new ReflectionAggregateFactory();
    }

    /** @test */
    public function player_can_be_registered(): void
    {
        $playerId = PlayerId::fromString('Elon Musk');

        $this->scenario
            ->when(function () use ($playerId) {
                return Player::register($playerId);
            })
            ->then([
                PlayerRegistered::withId($playerId),
            ])
        ;
    }
}
