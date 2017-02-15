<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Model;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class EloTest extends TestCase
{
    /** @test */
    public function it_represents_elo_score()
    {
        $elo = new Elo(0);

        Assert::assertSame(0, $elo->toInt());
    }

    /** @test */
    public function it_computes_score_after_winning()
    {
        Assert::assertSame(1520, (new Elo(1500))->afterWinningAgainst(new Elo(1600))->toInt());
        Assert::assertSame(1516, (new Elo(1500))->afterWinningAgainst(new Elo(1500))->toInt());
        Assert::assertSame(1511, (new Elo(1500))->afterWinningAgainst(new Elo(1400))->toInt());
    }

    /** @test */
    public function it_computes_score_after_drawing()
    {
        Assert::assertSame(1504, (new Elo(1500))->afterDrawingAgainst(new Elo(1600))->toInt());
        Assert::assertSame(1500, (new Elo(1500))->afterDrawingAgainst(new Elo(1500))->toInt());
        Assert::assertSame(1495, (new Elo(1500))->afterDrawingAgainst(new Elo(1400))->toInt());
    }

    /** @test */
    public function it_computes_score_after_losing()
    {
        Assert::assertSame(1488, (new Elo(1500))->afterLosingAgainst(new Elo(1600))->toInt());
        Assert::assertSame(1484, (new Elo(1500))->afterLosingAgainst(new Elo(1500))->toInt());
        Assert::assertSame(1479, (new Elo(1500))->afterLosingAgainst(new Elo(1400))->toInt());
    }

    /** @test */
    public function it_is_immutable()
    {
        $elo = new Elo(1000);

        Assert::assertNotSame($elo, $elo->afterWinningAgainst(new Elo(1000)));
        Assert::assertNotSame($elo, $elo->afterDrawingAgainst(new Elo(1000)));
        Assert::assertNotSame($elo, $elo->afterLosingAgainst(new Elo(1000)));
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function it_cannot_be_created_with_score_less_than_zero()
    {
        new Elo(-1);
    }
}
