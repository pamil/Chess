<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Application\CommandHandler;

use Broadway\CommandHandling\CommandHandlerInterface;
use Pamil\Chess\Player\Application\Command\RegisterPlayer;
use Pamil\Chess\Player\Domain\Model\Player;
use Pamil\Chess\Player\Application\Repository\PlayerRepository;

final class RegisterPlayerHandler implements CommandHandlerInterface
{
    /** @var PlayerRepository */
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(RegisterPlayer $command): void
    {
        $player = Player::register($command->id());

        $this->playerRepository->save($player);
    }

    public function handle($command): void
    {
        $this($command);
    }
}
