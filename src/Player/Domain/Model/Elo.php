<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Model;

final class Elo
{
    /** @var int */
    private $score;

    public function __construct(int $score)
    {
        if ($score < 0) {
            throw new \InvalidArgumentException('Elo score cannot be less than 0.');
        }

        $this->score = $score;
    }

    public function toInt(): int
    {
        return $this->score;
    }
}
