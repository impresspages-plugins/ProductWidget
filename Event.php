<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 6/24/14
 * Time: 10:01 PM
 */

namespace Plugin\SimpleProduct;

class Event
{
    public static function ipBeforeController()
    {
        ipAddCss('assets/simpleProduct.css');
        ipAddJs('assets/simpleProduct.js');
    }


}
