<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Application\Repository;

use Pamil\Chess\Match\Application\Exception\MatchNotFound;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;

interface MatchRepository
{
    /**
     * @throws MatchNotFound
     */
    public function get(MatchId $id): Match;

    public function save(Match $match): void;
}
