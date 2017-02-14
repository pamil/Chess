<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Exception;

use Pamil\Chess\Match\Domain\Model\MatchId;

final class MatchNotFound extends \DomainException
{
    public static function withId(MatchId $id): self
    {
        return new self(sprintf('Match with id "%s" not found!', $id->toString()));
    }
}
