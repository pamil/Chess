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

    private function __construct(MatchId $matchId, MatchResult $result)
    {
        $this->matchId = $matchId;
        $this->result = $result;
    }

    public static function withResult(MatchId $matchId, MatchResult $result): self
    {
        return new self($matchId, $result);
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
