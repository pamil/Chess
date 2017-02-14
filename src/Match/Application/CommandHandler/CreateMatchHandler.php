<?php

declare(strict_types=1);

namespace Pamil\Chess\Match\Application\CommandHandler;

use Pamil\Chess\Match\Application\Command\CreateMatch;
use Pamil\Chess\Match\Domain\Model\Match;
use Pamil\Chess\Match\Domain\Repository\MatchRepository;

final class CreateMatchHandler
{
    /** @var MatchRepository */
    private $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function __invoke(CreateMatch $command): void
    {
        $match = Match::create($command->whitePlayerId(), $command->blackPlayerId());

        $this->matchRepository->add($match);
    }
}
