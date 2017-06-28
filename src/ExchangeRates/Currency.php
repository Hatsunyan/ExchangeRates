<?php
/**
 * Created by PhpStorm.
 * User: Hatsu
 * Date: 26.06.2017
 * Time: 19:56
 */

namespace Hatsunyan\ExchangeRates;


class Currency
{
    protected $name;
    protected $value;
    protected $code;
    protected $charCode;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) :void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getValue() : float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value) : void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCode() : string
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code) : void
    {
        $this->code = $code;
    }


    /**
     * @return string
     */
    public function getCharCode() : string
    {
        return $this->charCode;
    }

    /**
     * @param string $charCode
     */
    public function setCharCode($charCode) : void
    {
        $this->charCode = $charCode;
    }


}