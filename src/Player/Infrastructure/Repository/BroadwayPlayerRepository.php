<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Infrastructure\Repository;

use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\Repository\AggregateNotFoundException;
use Pamil\Chess\Player\Application\Exception\PlayerNotFound;
use Pamil\Chess\Player\Domain\Model\Player;
use Pamil\Chess\Player\Domain\Model\PlayerId;
use Pamil\Chess\Player\Application\Repository\PlayerRepository;

final class BroadwayPlayerRepository implements PlayerRepository
{
    /** @var EventSourcingRepository */
    private $eventSourcingRepository;

    public function __construct(EventSourcingRepository $eventSourcingRepository)
    {
        $this->eventSourcingRepository = $eventSourcingRepository;
    }

    public function get(PlayerId $playerId): Player
    {
        try {
            /** @noinspection PhpIncompatibleReturnTypeInspection */
            return $this->eventSourcingRepository->load($playerId->toString());
        } catch (AggregateNotFoundException $exception) {
            throw PlayerNotFound::withId($playerId, $exception);
        }
    }

    public function save(Player $player): void
    {
        $this->eventSourcingRepository->save($player);
    }
}
