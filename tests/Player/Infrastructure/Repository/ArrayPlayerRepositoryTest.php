<?php

declare(strict_types=1);

namespace Tests\Pamil\Chess\Player\Infrastructure\Repository;

use Pamil\Chess\Player\Domain\Model\Player;
use Pamil\Chess\Player\Domain\Model\PlayerId;
use Pamil\Chess\Player\Infrastructure\Repository\ArrayPlayerRepository;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ArrayPlayerRepositoryTest extends TestCase
{
    /** @test */
    public function it_stores_a_player()
    {
        $repository = new ArrayPlayerRepository();

        $playerId = PlayerId::fromString('Elon Musk');
        $player = Player::register($playerId);

        $repository->save($player);

        Assert::assertSame($player, $repository->get($playerId));
    }

    /**
     * @test
     *
     * @expectedException \Pamil\Chess\Player\Application\Exception\PlayerNotFound
     */
    public function it_cannot_return_an_unexisting_player()
    {
        $repository = new ArrayPlayerRepository();

        $repository->get(PlayerId::fromString('Elon Musk'));
    }
}
