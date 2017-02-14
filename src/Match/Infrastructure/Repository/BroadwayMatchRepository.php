<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Infrastructure\Repository;

use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\Repository\AggregateNotFoundException;
use Pamil\Chess\Match\Domain\Exception\MatchNotFound;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Repository\MatchRepository;

final class BroadwayMatchRepository implements MatchRepository
{
    /** @var EventSourcingRepository */
    private $eventSourcingRepository;

    public function __construct(EventSourcingRepository $eventSourcingRepository)
    {
        $this->eventSourcingRepository = $eventSourcingRepository;
    }

    public function get(MatchId $id): Match
    {
        try {
            /** @noinspection PhpIncompatibleReturnTypeInspection */
            return $this->eventSourcingRepository->load($id->toString());
        } catch (AggregateNotFoundException $exception) {
            throw MatchNotFound::withId($id, $exception);
        }
    }

    public function add(Match $match): void
    {
        $this->eventSourcingRepository->save($match);
    }
}
