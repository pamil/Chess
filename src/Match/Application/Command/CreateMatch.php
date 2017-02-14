<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Application\Command;

use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Model\PlayerId;

final class CreateMatch
{
    /** @var MatchId */
    private $matchId;

    /** @var PlayerId */
    private $whitePlayerId;

    /** @var PlayerId */
    private $blackPlayerId;

    private function __construct(MatchId $matchId, PlayerId $whitePlayerId, PlayerId $blackPlayerId)
    {
        $this->matchId = $matchId;
        $this->whitePlayerId = $whitePlayerId;
        $this->blackPlayerId = $blackPlayerId;
    }

    public static function betweenPlayers(MatchId $matchId, PlayerId $whitePlayerId, PlayerId $blackPlayerId): self
    {
        return new self($matchId, $whitePlayerId, $blackPlayerId);
    }

    public function matchId(): MatchId
    {
        return $this->matchId;
    }

    public function whitePlayerId(): PlayerId
    {
        return $this->whitePlayerId;
    }

    public function blackPlayerId(): PlayerId
    {
        return $this->blackPlayerId;
    }
}
