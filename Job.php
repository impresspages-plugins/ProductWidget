<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 8/11/14
 * Time: 8:21 AM
 */

namespace Plugin\SimpleProduct;


class Job
{
    public static function ipConvertCurrency($amount, $sourceCurrency, $destinationCurrency)
    {
        $sourceRate = CurrencyModel::getCurrencyRate($sourceCurrency);
        $destinationRate = CurrencyModel::getCurrencyRate($destinationCurrency);
        if ($sourceRate !== null && $destinationRate !== null) {
            $newAmount = $amount / $sourceRate * $destinationRate;
            return $newAmount;
        }
    }
}
