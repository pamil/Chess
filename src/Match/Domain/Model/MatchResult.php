<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Domain\Model;

final class MatchResult
{
    private const WHITE_WON = 'W';
    private const DRAW = 'D';
    private const BLACK_WON = 'B';

    /** @var string[] */
    private static $availableStates = [self::WHITE_WON, self::DRAW, self::BLACK_WON];

    /** @var MatchResult[] */
    private static $flyweights = [];

    /** @var string */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        if (!in_array($value, self::$availableStates, true)) {
            throw new \InvalidArgumentException(sprintf(
                'Match result must be one of %s; got "%s" instead.',
                '"'. implode('", "', self::$availableStates) . '"',
                $value
            ));
        }

        return self::getFlyweight($value);
    }

    public static function whiteWon(): self
    {
        return self::getFlyweight(self::WHITE_WON);
    }

    public static function draw(): self
    {
        return self::getFlyweight(self::DRAW);
    }

    public static function blackWon(): self
    {
        return self::getFlyweight(self::BLACK_WON);
    }

    public function toString(): string
    {
        return $this->value;
    }

    private static function getFlyweight(string $value): self
    {
        if (!array_key_exists($value, self::$flyweights)) {
            self::$flyweights[$value] = new self($value);
        }

        return self::$flyweights[$value];
    }
}
