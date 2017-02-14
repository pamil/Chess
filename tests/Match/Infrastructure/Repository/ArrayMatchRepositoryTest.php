<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Match\Infrastructure\Repository;

use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Model\MatchId;
use Pamil\Chess\Match\Domain\Model\PlayerId;
use Pamil\Chess\Match\Infrastructure\Repository\ArrayMatchRepository;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ArrayMatchRepositoryTest extends TestCase
{
    /** @test */
    public function it_stores_a_match()
    {
        $repository = new ArrayMatchRepository();

        $matchId = MatchId::generate();
        $match = Match::create($matchId, PlayerId::fromString('White'), PlayerId::fromString('Black'));

        $repository->add($match);

        Assert::assertSame($match, $repository->get($matchId));
    }

    /**
     * @test
     *
     * @expectedException \Pamil\Chess\Match\Domain\Exception\MatchNotFound
     */
    public function it_throws_an_exception_if_match_cannot_be_found()
    {
        $repository = new ArrayMatchRepository();

        $repository->get(MatchId::generate());
    }
}
