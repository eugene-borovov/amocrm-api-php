<?php

declare(strict_types=1);

namespace AmoCRM\AmoCRM\Support;

/**
 * @template TKey of array-key
 *
 * @template-covariant TValue
 *
 * @template-implements \ArrayAccess<TKey, TValue>
 * @template-implements \IteratorAggregate<TKey, TValue>
 */
class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * The items contained in the collection.
     *
     * @var array<TKey, TValue>
     */
    protected $items = [];

    /**
     * Create a new collection.
     *
     * @param iterable<TKey, TValue>  $items
     * @return void
     */
    public function __construct($items = [])
    {
        if (is_array($items)) {
            $this->items = $items;
        } elseif ($items instanceof \Traversable) {
            $this->items = iterator_to_array($items);
        } else {
            throw new \InvalidArgumentException('Collections can not be created.');
        }
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator<TKey, TValue>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }


    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  TKey  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  TKey  $key
     * @return TValue
     */
    public function offsetGet($key)
    {
        return $this->items[$key];
    }

    /**
     * Set the item at a given offset.
     *
     * @param  TKey|null  $key
     * @param  TValue  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  TKey  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }
}
