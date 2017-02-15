<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Infrastructure\Repository;

use Pamil\Chess\Match\Domain\Exception\MatchNotFound;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Application\Repository\MatchRepository;

final class ArrayMatchRepository implements MatchRepository
{
    /** @var Match[] Indexed by stringified MatchId */
    private $matches = [];

    public function get(MatchId $id): Match
    {
        if (!array_key_exists($id->toString(), $this->matches)) {
            throw MatchNotFound::withId($id);
        }

        return $this->matches[$id->toString()];
    }

    public function save(Match $match): void
    {
        $this->matches[$match->id()->toString()] = $match;
    }
}
