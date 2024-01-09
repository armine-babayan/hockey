<?php
declare(strict_types=1);

namespace Hockey;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
/**
 * @template-implements ArrayAccess<int, Player>
 * @template-implements IteratorAggregate<int, Player>
 */
final class Team implements Countable, IteratorAggregate, ArrayAccess
{

    /**
     * @var array<int, Player>
     */
    private array  $sortedPlayers = [];

    /**
     * @param string $country
     * @param array<int, Player> $players
     */
    public function __construct(
        private readonly string $country,
        array  $players = []
    )
    {
        foreach ($players as $player) {
            $this->sortedPlayers[$player->getNumber()] = $player;
        }
    }

    public function count(): int
    {
        return count($this->sortedPlayers);
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPlayerByNumber(int $number): Player
    {
        return $this->sortedPlayers[$number];
    }

    /**
     * @return Traversable<int, Player>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->sortedPlayers);
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->sortedPlayers[$offset]);
    }

    /**
     * @param int $offset
     * @return Player
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->sortedPlayers[$offset];
    }

    /**
     * @param int $offset
     * @param Player $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->sortedPlayers[$value->getNumber()] = $value;
    }

    /**
     * @param int $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->sortedPlayers[$offset]);
    }
}