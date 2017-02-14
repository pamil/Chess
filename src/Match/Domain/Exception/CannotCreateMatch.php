<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Exception;

use Pamil\Chess\Match\Domain\Model\PlayerId;

final class CannotCreateMatch extends \DomainException
{
    public static function withSinglePlayer(PlayerId $playerId): self
    {
        return new self(sprintf('Cannot create match with single player "%s".', $playerId->toString()));
    }
}
