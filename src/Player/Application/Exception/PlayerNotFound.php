<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Application\Exception;

use Pamil\Chess\Player\Domain\Model\PlayerId;

final class PlayerNotFound extends \DomainException
{
    public static function withId(PlayerId $playerId, \Exception $previous = null): self
    {
        return new self(sprintf('Player with id "%s" not found!', $playerId->toString()), 0, $previous);
    }
}
