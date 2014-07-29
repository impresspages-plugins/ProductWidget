<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.7.21
 * Time: 17.56
 */

namespace Plugin\SimpleProduct;


class Model
{
    public static function getCurrency()
    {
        return ipGetOption('SimpleProduct.currency', 'USD');
    }

}
