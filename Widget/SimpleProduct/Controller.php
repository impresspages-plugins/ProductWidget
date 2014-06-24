<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 6/22/14
 * Time: 11:04 PM
 */

namespace Plugin\ProductWidget\Widget\SimpleProduct;


class Controller extends \Ip\WidgetController
{


    /**
     * Gets widget title
     *
     * Override this method to set the widget name displayed in widget toolbar.
     *
     * @return string Widget's title
     */
    public function getTitle()
    {
        return __('Product', 'ProductWidget', false);
    }



}
