# Example
```php
$ex = new \Hatsunyan\ExchangeRates\Rates();
$curency = $ex
    ->setDateString('2016-10-10') // set date, default now
    ->getRate() // get rates
    ->getRateByCode('USD'); //get currency
    
$currency->getValue();    
```
