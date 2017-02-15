<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Model;

final class Elo
{
    private const K = 32;

    /** @var int */
    private $score;

    public function __construct(int $score)
    {
        if ($score < 0) {
            throw new \InvalidArgumentException('Elo score cannot be less than 0.');
        }

        $this->score = $score;
    }

    public static function getProbabilityOfWinning(self $subject, self $opponent): float
    {
        $transformedOfScore = 10 ** ($subject->score / 400);
        $transformedVersusScore = 10 ** ($opponent->score / 400);

        return $transformedOfScore / ($transformedOfScore + $transformedVersusScore);
    }

    public function afterWinningAgainst(self $opponent): self
    {
        return new self($this->score + $this->getDelta(1, self::getProbabilityOfWinning($this, $opponent)));
    }

    public function afterDrawingAgainst(self $opponent): self
    {
        return new self($this->score + $this->getDelta(0.5, self::getProbabilityOfWinning($this, $opponent)));
    }

    public function afterLosingAgainst(self $opponent): self
    {
        return new self($this->score + $this->getDelta(0, self::getProbabilityOfWinning($this, $opponent)));
    }

    public function toInt(): int
    {
        return $this->score;
    }

    private function getDelta(float $result, float $probability): int
    {
        return (int) floor(self::K * ($result - $probability));
    }
}
