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
    public function it_represents_elo_score(): void
    {
        $elo = new Elo(0);

        Assert::assertSame(0, $elo->toInt());
    }

    /** @test */
    public function it_computes_score_after_winning(): void
    {
        Assert::assertSame(20, (new Elo(0))->afterWinningAgainst(new Elo(100))->toInt());
        Assert::assertSame(16, (new Elo(0))->afterWinningAgainst(new Elo(0))->toInt());
        Assert::assertSame(12, (new Elo(0))->afterWinningAgainst(new Elo(-100))->toInt());
    }

    /** @test */
    public function it_computes_score_after_drawing(): void
    {
        Assert::assertSame(4, (new Elo(0))->afterDrawingAgainst(new Elo(100))->toInt());
        Assert::assertSame(0, (new Elo(0))->afterDrawingAgainst(new Elo(0))->toInt());
        Assert::assertSame(-4, (new Elo(0))->afterDrawingAgainst(new Elo(-100))->toInt());
    }

    /** @test */
    public function it_computes_score_after_losing(): void
    {
        Assert::assertSame(-12, (new Elo(0))->afterLosingAgainst(new Elo(100))->toInt());
        Assert::assertSame(-16, (new Elo(0))->afterLosingAgainst(new Elo(0))->toInt());
        Assert::assertSame(-20, (new Elo(0))->afterLosingAgainst(new Elo(-100))->toInt());
    }

    /** @test */
    public function it_is_immutable(): void
    {
        $elo = new Elo(0);

        Assert::assertNotSame($elo, $elo->afterWinningAgainst(new Elo(0)));
        Assert::assertNotSame($elo, $elo->afterDrawingAgainst(new Elo(0)));
        Assert::assertNotSame($elo, $elo->afterLosingAgainst(new Elo(0)));
    }

    /** @test */
    public function sum_of_win_probabilities_is_always_one(): void
    {
        $this
            ->forAll(Generator\choose(-5000, 5000), Generator\choose(-5000, 5000))
            ->then(function (int $firstScore, int $secondScore): void {
                $firstElo = new Elo($firstScore);
                $secondElo = new Elo($secondScore);

                Assert::assertSame(1.0, Elo::getWinProbability($firstElo, $secondElo) + Elo::getWinProbability($secondElo, $firstElo));
            })
        ;
    }

    /** @test */
    public function win_probability_is_relative(): void
    {
        $this
            ->limitTo(20)
            ->forAll(Generator\choose(-5000, 5000))
            ->then(function (int $score): void {
                $elo = new Elo($score);

                Assert::assertSame(0.64, round(Elo::getWinProbability($elo, new Elo($score - 100)), 2));
                Assert::assertSame(0.36, round(Elo::getWinProbability($elo, new Elo($score + 100)), 2));
            })
        ;
    }

    /** @test */
    public function sum_of_scores_is_always_the_same_after_a_match()
    {
        $this
            ->forAll(Generator\choose(-5000, 5000), Generator\choose(-5000, 5000))
            ->then(function (int $firstScoreBefore, int $secondScoreBefore): void {
                $sumOfScoresBefore = $firstScoreBefore + $secondScoreBefore;

                $firstScoreAfter = (new Elo($firstScoreBefore))->afterWinningAgainst(new Elo($secondScoreBefore))->toInt();
                $secondScoreAfter = (new Elo($secondScoreBefore))->afterLosingAgainst(new Elo($firstScoreBefore))->toInt();
                $sumOfScoresAfter = $firstScoreAfter + $secondScoreAfter;

                Assert::assertSame(
                    $sumOfScoresBefore,
                    $sumOfScoresAfter,
                    sprintf(
                        'Sum of scores does not match after %d (became %d) won against %d (became %d).',
                        $firstScoreBefore,
                        $firstScoreAfter,
                        $secondScoreBefore,
                        $secondScoreAfter
                    )
                );
            })
        ;

        $this
            ->forAll(Generator\choose(-5000, 5000), Generator\choose(-5000, 5000))
            ->then(function (int $firstScoreBefore, int $secondScoreBefore): void {
                $sumOfScoresBefore = $firstScoreBefore + $secondScoreBefore;

                $firstScoreAfter = (new Elo($firstScoreBefore))->afterDrawingAgainst(new Elo($secondScoreBefore))->toInt();
                $secondScoreAfter = (new Elo($secondScoreBefore))->afterDrawingAgainst(new Elo($firstScoreBefore))->toInt();
                $sumOfScoresAfter = $firstScoreAfter + $secondScoreAfter;

                Assert::assertSame(
                    $sumOfScoresBefore,
                    $sumOfScoresAfter,
                    sprintf(
                        'Sum of scores does not match after %d (became %d) drew against %d (became %d).',
                        $firstScoreBefore,
                        $firstScoreAfter,
                        $secondScoreBefore,
                        $secondScoreAfter
                    )
                );
            })
        ;
    }
}
