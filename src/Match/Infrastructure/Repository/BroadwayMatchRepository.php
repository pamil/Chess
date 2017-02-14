<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Infrastructure\Repository;

use Broadway\EventSourcing\EventSourcingRepository;
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
        return $this->eventSourcingRepository->load($id->toString());
    }

    public function add(Match $match): void
    {
        $this->eventSourcingRepository->save($match);
    }
}
