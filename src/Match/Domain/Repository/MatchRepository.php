<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Repository;

use Pamil\Chess\Match\Domain\Exception\MatchNotFound;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;

interface MatchRepository
{
    /**
     * @throws MatchNotFound
     */
    public function get(MatchId $id): Match;

    public function add(Match $match): void;
}
