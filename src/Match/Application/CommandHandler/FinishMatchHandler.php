<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Application\CommandHandler;

use Broadway\CommandHandling\CommandHandlerInterface;
use Pamil\Chess\Match\Application\Command\FinishMatch;
use Pamil\Chess\Match\Domain\Repository\MatchRepository;

final class FinishMatchHandler implements CommandHandlerInterface
{
    /** @var MatchRepository */
    private $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function __invoke(FinishMatch $command): void
    {
        $match = $this->matchRepository->get($command->matchId());

        $match->finish($command->result());

        $this->matchRepository->save($match);
    }

    public function handle($command): void
    {
        $this($command);
    }
}
