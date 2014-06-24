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

namespace Plugin\ProductWidget;


class Event
{
    public static function ipBeforeController()
    {
        ipAddCss('assets/productWidget.css');
    }
}
