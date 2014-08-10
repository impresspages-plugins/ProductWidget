<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.7.20
 * Time: 12.14
 */

namespace Plugin\SimpleProduct;


class CurrencyModel
{
    public static function getCurrencyList()
    {
        $currencies = ipDb()->selectColumn('simple_product_currency', 'currency', null, ' ORDER BY `priority` desc, `currency` asc');
        return $currencies ;
    }


    public static function getCurrencyRate($currency)
    {
        $ratio = ipDb()->selectValue('simple_product_currency', 'ratio', array('currency' => $currency));
        return $ratio;
    }



}
