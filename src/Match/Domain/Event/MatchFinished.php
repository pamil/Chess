<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Event;

use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Model\MatchResult;

final class MatchFinished
{
    /** @var MatchId */
    private $matchId;

    /** @var MatchResult */
    private $result;

    public function __construct(MatchId $matchId, MatchResult $result)
    {
        $this->matchId = $matchId;
        $this->result = $result;
    }

    public function matchId(): MatchId
    {
        return $this->matchId;
    }

    public function result(): MatchResult
    {
        return $this->result;
    }
}
