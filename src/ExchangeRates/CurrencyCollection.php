<?php
/**
 * Created by PhpStorm.
 * User: Hatsu
 * Date: 26.06.2017
 * Time: 20:02
 */

namespace Hatsunyan\ExchangeRates;



class CurrencyCollection implements \IteratorAggregate, \ArrayAccess
{
    protected $storage = [];

    public function set(string $key,Currency $val)
    {
        $this->storage[$key] = $val;
    }

    public function get(string $key) : Currency
    {
        if(!isset($this->storage['key']))
        {
            throw new RatesException('undefined key');
        }
        return $this->storage[$key];
    }

    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->storage);
    }

    public function offsetExists($offset)
    {
        return isset($this->storage[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->storage[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->storage[] = $value;
        } else {
            $this->storage[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->storage[$offset]);
    }
}