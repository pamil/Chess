<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Model;

use Eris\Generator;
use Eris\TestTrait;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class EloTest extends TestCase
{
    use TestTrait;

    /** @test */
    public function it_represents_elo_score()
    {
        $elo = new Elo(0);

        Assert::assertSame(0, $elo->toInt());
    }

    /** @test */
    public function it_computes_score_after_winning()
    {
        Assert::assertSame(20, (new Elo(0))->afterWinningAgainst(new Elo(100))->toInt());
        Assert::assertSame(16, (new Elo(0))->afterWinningAgainst(new Elo(0))->toInt());
        Assert::assertSame(11, (new Elo(0))->afterWinningAgainst(new Elo(-100))->toInt());
    }

    /** @test */
    public function it_computes_score_after_drawing()
    {
        Assert::assertSame(4, (new Elo(0))->afterDrawingAgainst(new Elo(100))->toInt());
        Assert::assertSame(0, (new Elo(0))->afterDrawingAgainst(new Elo(0))->toInt());
        Assert::assertSame(-5, (new Elo(0))->afterDrawingAgainst(new Elo(-100))->toInt());
    }

    /** @test */
    public function it_computes_score_after_losing()
    {
        Assert::assertSame(-12, (new Elo(0))->afterLosingAgainst(new Elo(100))->toInt());
        Assert::assertSame(-16, (new Elo(0))->afterLosingAgainst(new Elo(0))->toInt());
        Assert::assertSame(-21, (new Elo(0))->afterLosingAgainst(new Elo(-100))->toInt());
    }

    /** @test */
    public function it_is_immutable()
    {
        $elo = new Elo(0);

        Assert::assertNotSame($elo, $elo->afterWinningAgainst(new Elo(0)));
        Assert::assertNotSame($elo, $elo->afterDrawingAgainst(new Elo(0)));
        Assert::assertNotSame($elo, $elo->afterLosingAgainst(new Elo(0)));
    }

    /** @test */
    public function sum_of_win_probabilities_is_always_one()
    {
        $this
            ->forAll(Generator\choose(-5000, 5000), Generator\choose(-5000, 5000))
            ->then(function ($firstScore, $secondScore) {
                $firstElo = new Elo($firstScore);
                $secondElo = new Elo($secondScore);

                Assert::assertSame(1.0, Elo::getWinProbability($firstElo, $secondElo) + Elo::getWinProbability($secondElo, $firstElo));
            })
        ;
    }

    /** @test */
    public function win_probability_is_relative()
    {
        $this
            ->limitTo(20)
            ->forAll(Generator\choose(-5000, 5000))
            ->then(function ($score) {
                $elo = new Elo($score);

                Assert::assertSame(0.64, round(Elo::getWinProbability($elo, new Elo($score - 100)), 2));
                Assert::assertSame(0.36, round(Elo::getWinProbability($elo, new Elo($score + 100)), 2));
            })
        ;
    }
}
