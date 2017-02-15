<?php

declare(strict_types=1);

namespace Pamil\Chess\Player\Domain\Event;

use Pamil\Chess\Player\Domain\Model\PlayerId;

final class PlayerRegistered
{
    /** @var PlayerId */
    private $id;

    private function __construct(PlayerId $id)
    {
        $this->id = $id;
    }

    public static function withId(PlayerId $id): self
    {
        return new self($id);
    }

    public function id(): PlayerId
    {
        return $this->id;
    }
}
