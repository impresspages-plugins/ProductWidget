<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 8/10/14
 * Time: 7:21 PM
 */

namespace Plugin\SimpleProduct;


class CountryHelper {

    /**
     * Prents deletion of last country in GRID
     * @param $method
     * @param $params
     * @param $statusVariables
     * @return array|null
     * @throws \Ip\Exception
     */
    public static function preventAction($method, $params, $statusVariables)
    {
        if ($method === 'delete') {
            $countries = CountryModel::getCountryList();
            if (count($countries) === 1) {
                return __('Can\'t delete the last country.', 'SimpleProduct', false);
            }
        }
        return null;
    }

}
