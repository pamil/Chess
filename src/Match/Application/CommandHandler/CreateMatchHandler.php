<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Application\CommandHandler;

use Broadway\CommandHandling\CommandHandlerInterface;
use Pamil\Chess\Match\Application\Command\CreateMatch;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Application\Repository\MatchRepository;

final class CreateMatchHandler implements CommandHandlerInterface
{
    /** @var MatchRepository */
    private $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function __invoke(CreateMatch $command): void
    {
        $match = Match::create($command->matchId(), $command->whitePlayerId(), $command->blackPlayerId());

        $this->matchRepository->save($match);
    }

    public function handle($command): void
    {
        $this($command);
    }
}
