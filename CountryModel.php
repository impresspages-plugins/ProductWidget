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
        $countries = ipDb()->selectColumn('product_widget_country', 'title', null, ' ORDER BY `priority` desc, `title` asc');
        return $countries;
    }

    public static function getDefaultCountry()
    {
        $defaultCountry = ipDb()->selectRow('product_widget_country', '*', array('isDefault' => 1), '  ORDER BY `priority` desc, `title` asc');
        if (!$defaultCountry) {
            $defaultCountry = array_shift(self::getCountryList());
        }
        return $defaultCountry;
    }

    public static function getCountryByTitle($title)
    {
        $country = ipDb()->selectRow('product_widget_country', '*', array('title' => $title), '  ORDER BY `priority` desc, `title` asc');
        return $country;
    }
}
