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
    public static function ipConvertCurrency($data)
    {
        $amount = $data['amount'];
        $sourceCurrency = $data['sourceCurrency'];
        $destinationCurrency = $data['destinationCurrency'];
        $sourceRate = CurrencyModel::getCurrencyRate($sourceCurrency);
        $destinationRate = CurrencyModel::getCurrencyRate($destinationCurrency);
        if ($sourceRate !== null && $destinationRate !== null) {
            $newAmount = $amount / $sourceRate * $destinationRate;
            return $newAmount;
        }
    }
}
