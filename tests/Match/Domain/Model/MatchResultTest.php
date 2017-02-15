<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Match\Domain\Model;

use Pamil\Chess\Match\Domain\Model\MatchResult;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class MatchResultTest extends TestCase
{
    /** @test */
    public function it_represents_a_win_of_white(): void
    {
        $matchResult = MatchResult::whiteWon();

        Assert::assertInstanceOf(MatchResult::class, $matchResult);
        Assert::assertSame('W', $matchResult->toString());
    }

    /** @test */
    public function it_represents_a_draw(): void
    {
        $matchResult = MatchResult::draw();

        Assert::assertInstanceOf(MatchResult::class, $matchResult);
        Assert::assertSame('D', $matchResult->toString());
    }

    /** @test */
    public function it_represents_a_win_of_black(): void
    {
        $matchResult = MatchResult::blackWon();

        Assert::assertInstanceOf(MatchResult::class, $matchResult);
        Assert::assertSame('B', $matchResult->toString());
    }

    /** @test */
    public function it_is_created_from_a_valid_string(): void
    {
        Assert::assertSame('W', MatchResult::fromString('W')->toString());
        Assert::assertSame('D', MatchResult::fromString('D')->toString());
        Assert::assertSame('B', MatchResult::fromString('B')->toString());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Match result must be one of "W", "D", "B"; got "X" instead.
     */
    public function it_cannot_be_created_from_an_invalid_string(): void
    {
        MatchResult::fromString('X');
    }

    /** @test */
    public function it_reuses_the_same_objects_for_each_type(): void
    {
        Assert::assertSame(MatchResult::whiteWon(), MatchResult::fromString('W'));
        Assert::assertSame(MatchResult::draw(), MatchResult::fromString('D'));
        Assert::assertSame(MatchResult::blackWon(), MatchResult::fromString('B'));
    }
}
