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


class CountryModel
{
    public static function getCountryList()
    {
        $countries = ipDb()->selectColumn('simple_product_country', 'title', null, ' ORDER BY `priority` desc, `title` asc');
        return $countries;
    }

    public static function getDefaultCountry()
    {
        $defaultCountry = ipDb()->selectRow('simple_product_country', '*', array('isDefault' => 1), '  ORDER BY `priority` desc, `title` asc');
        if (!$defaultCountry) {
            $countryList = self::getCountryList();
            $defaultCountry = self::getCountryByTitle(array_shift($countryList));
        }
        return $defaultCountry;
    }

    public static function getCountryByTitle($title)
    {
        $country = ipDb()->selectRow('simple_product_country', '*', array('title' => $title), '  ORDER BY `priority` desc, `title` asc');
        return $country;
    }
}
