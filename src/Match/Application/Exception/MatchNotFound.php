<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Application\Exception;

use Pamil\Chess\Match\Domain\Model\MatchId;

final class MatchNotFound extends \DomainException
{
    public static function withId(MatchId $matchId, \Exception $previous = null): self
    {
        return new self(sprintf('Match with id "%s" not found!', $matchId->toString()), 0, $previous);
    }
}
