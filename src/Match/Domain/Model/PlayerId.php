<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Model;

final class PlayerId
{
    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
