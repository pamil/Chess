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
