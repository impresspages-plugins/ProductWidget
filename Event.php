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

    public static function ipPaymentReceived($info)
    {
        $idParts = explode('_', $info['id']);
        if ($idParts[0] != 'SimpleProduct' || count($idParts) != 2) {
            return;
        }

        $orderId = $idParts[1];


        OrderModel::processPayment($orderId);
    }


}
