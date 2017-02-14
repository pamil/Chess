<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Match\Domain\Model;

use Pamil\Chess\Match\Domain\Model\MatchId;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class MatchIdTest extends TestCase
{
    /** @test */
    public function it_can_be_created_from_uuid_string()
    {
        $matchId = MatchId::fromString('67c99578-798c-428a-a3fa-08ac9e20f8dd');

        Assert::assertInstanceOf(MatchId::class, $matchId);
        Assert::assertSame('67c99578-798c-428a-a3fa-08ac9e20f8dd', $matchId->toString());
    }

    /** @test */
    public function it_can_be_generated()
    {
        $matchId = MatchId::generate();

        Assert::assertInstanceOf(MatchId::class, $matchId);
        Assert::assertRegExp('/' . Uuid::VALID_PATTERN . '/', $matchId->toString());
    }

    /**
     * @test
     *
     * @expectedException \InvalidArgumentException
     */
    public function it_cannot_be_created_from_string_not_being_uuid()
    {
        MatchId::fromString('Elon Musk');
    }
}
