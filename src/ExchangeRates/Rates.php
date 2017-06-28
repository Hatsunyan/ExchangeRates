<?php

/**
 * Created by PhpStorm.
 * User: Hatsu
 * Date: 26.06.2017
 * Time: 18:27
 */
namespace Hatsunyan\ExchangeRates;

class Rates
{
    protected $url = 'http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL';
    protected $client;
    protected $rates;
    protected $date;

    function __construct()
    {
        if(!class_exists('\SoapClient'))
        {
            throw new RatesException('SoapClient must be enabled');
        }
        if(!class_exists('\SimpleXMLElement'))
        {
            throw new RatesException('SimpleXML must be enabled');
        }
        $this->client = new \SoapClient($this->url);
        $this->date = date('Y-m-d');
    }


    function getRate()
    {
        $this->rates = new CurrencyCollection();
        $result = $this->client->GetCursOnDate(['On_date'=>$this->date]);
        try
        {
            $ratesObj = new \SimpleXMLElement($result->GetCursOnDateResult->any);
        }catch (\Exception $e)
        {
            throw $e;
        }

//        if($ratesObj->count() === 0)
//        {
//            throw new RatesException('empty response');
//        }
        foreach($ratesObj->ValuteData->ValuteCursOnDate as $r)
        {
            $currency = new Currency();
            $currency->setCharCode((string) $r->VchCode);
            $currency->setCode((int) $r->Vcode);
            $currency->setName((string) $r->Vname);
            if((int) $r->Vnom > 1 )
            {
                $currency->setValue((float) $r->Vcurs / (int) $r->Vnom);
            }else{
                $currency->setValue((float) $r->Vcurs);
            }

            // add to collection
            $this->rates->set((string) $r->VchCode,$currency);
        }
        return $this;
    }


    /**
     * @param string $date
     * @return Rates
     * @throws \Exception
     */
    public function setDateString(string $date) : Rates
    {
        if(\DateTime::createFromFormat('Y-m-d', $date) === false)
        {
            throw new RatesException('Wrong date format, date must by Y-m-d');
        }
        $time = strtotime($date);
        if($time > time())
        {
            throw new \Exception('Date must by in past');
        }
        if($time)
        {
            $this->date = date('Y-m-d',$time);
        }else{
            throw new RatesException('Wrong date format');
        }
        return $this;
    }


    /**
     * @param int $time
     * @return Rates
     * @throws \Exception
     */
    public function setDateUnix(int $time) : Rates
    {
        $date = date('Y-m-d',$time);
        if($date)
        {
            $this->date = date('Y-m-d',$time);
        }else{
            throw new RatesException('Wrong time format');
        }
        return $this;
    }


    /**
     * @param string $code
     * @return Currency
     * @throws RatesException
     */
    public function getRateByCode(string  $code) : Currency
    {
        $code = strtoupper($code);
        if(!isset($this->rates[$code]))
        {
            throw new RatesException('undefined currency code '.$code);
        }
        return $this->rates[$code];
    }


    /**
     * @return CurrencyCollection
     */
    public function getAllRates() : CurrencyCollection
    {
        return $this->rates;
    }
}