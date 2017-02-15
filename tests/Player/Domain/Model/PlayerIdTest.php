<?php

declare(strict_types=1);

namespace Tests\Pamil\Player\Match\Domain\Model;

use Pamil\Chess\Match\Domain\Model\PlayerId;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class PlayerIdTest extends TestCase
{
    /** @test */
    public function it_can_be_created_from_string(): void
    {
        $playerId = PlayerId::fromString('Nikola Tesla');

        Assert::assertInstanceOf(PlayerId::class, $playerId);
        Assert::assertSame('Nikola Tesla', $playerId->toString());
    }
}
