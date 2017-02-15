<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Event;

use Pamil\Chess\Player\Domain\Model\PlayerId;

final class PlayerRated
{
    /** @var PlayerId */
    private $id;

    /** @var int */
    private $elo;

    private function __construct(PlayerId $id, int $elo)
    {
        $this->id = $id;
        $this->elo = $elo;
    }

    public static function withElo(PlayerId $id, int $elo): self
    {
        return new self($id, $elo);
    }

    public function id(): PlayerId
    {
        return $this->id;
    }

    public function elo(): int
    {
        return $this->elo;
    }
}
