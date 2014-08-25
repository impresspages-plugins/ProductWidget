<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 6/24/14
 * Time: 4:25 PM
 */

namespace Plugin\SimpleProduct;


class AdminController
{

    /**
     * @ipSubmenu Orders
     * @return string
     */
    public function index()
    {
        $config = array(
            'title' => __('Orders', 'SimpleProduct', false),
            'table' => 'simple_product_order',
            'orderBy' => 'id desc',
            'allowCreate' => false
        );

        $config = ipFilter('SimpleProduct_orderGridConfig', $config);

        return ipGridController($config);
    }

    /**
     * @ipSubmenu Countries
     */
    public function countries()
    {
        $config = array(
            'title' => __('Countries', 'SimpleProduct', false),
            'table' => 'simple_product_country',
            'sortField' => 'priority',
            'orderBy' => 'priority, title',
            'preventAction' => 'Plugin\SimpleProduct\CountryHelper::preventAction',
            'fields' => array(
                array(
                    'label' => __('Title', 'SimpleProduct', false),
                    'field' => 'title',
                    'validators' => array('Required')
                ),
                array(
                    'type' => 'Currency',
                    'currencyField' => 'currency',
                    'label' => __('Delivery cost', 'SimpleProduct', false),
                    'field' => 'deliveryCost',
                    'validators' => array('Required')
                ),
                array(
                    'label' => __('Delivery currency', 'SimpleProduct', false),
                    'field' => 'currency',
                    'transformations' => array('Trim', 'UpperCase'),
                    'validators' => array('Required', array('Regex', '/^[A-Z][A-Z][A-Z]$/'))
                ),
                array(
                    'type' => 'Checkbox',
                    'label' => __('Default', 'SimpleProduct', false),
                    'hint' => __('Select one country to be the default one.', 'SimpleProduct', false),
                    'field' => 'isDefault'
                )
            )
        );
        $config = ipFilter('SimpleProduct_countriesGridConfig', $config);

        return ipGridController($config);
    }

    /**
     * @ipSubmenu Currencies
     */
    public function currencies()
    {
        $config = array(
            'title' => __('Currencies', 'SimpleProduct', false),
            'table' => 'simple_product_currency',
            'sortField' => 'priority',
            'createPosition' => 'bottom',
            'fields' => array(
                array(
                    'label' => __('Currency', 'SimpleProduct', false),
                    'field' => 'currency',
                    'transformations' => array('Trim', 'UpperCase'),
                    'validators' => array(
                        'Required',
                        array('Regex', '/^[A-Z][A-Z][A-Z]$/', __('Please use three uppercase letter abbreviation. Eg. USD', 'SimpleProduct', false))
                    )
                ),
                array(
                    'label' => __('Rate', 'SimpleProduct', false),
                    'field' => 'rate',
                    'transformations' => array('Trim'),
                    'validators' => array(
                        'Required',
                        array('Regex', '/^[0-9]+(\.[0-9]+)?$/', __('Incorrect value. Eg. value 1.123', 'SimpleProduct', false)),
                        array('NotInArray', array('0'))
                    ),
                    'note' => __('Rate when converting from / to this currency. Calculations are done using the equation: currency1amount / ratio1 = currency2amount / ratio2. We suggest to set your main currency ratio to 1 to ease the calculations. Let say USD is set to 1. Then setting EUR = 0.76 means that 1 USD is equal to 0.76 EUR.', 'SimpleProduct', false)
                )

            )
        );
        $config = ipFilter('SimpleProduct_countriesGridConfig', $config);

        $answer = '';
        if (ipRequest()->getRequest('method') == '') {
            $answer .= '<p class="alert alert-success">' . __('You have to use this module only if you enter products / shipping rates in different currencies. If you use the single currency, you can skip filling this table.', 'SimpleProduct') . '</p>';
            $answer .= ipGridController($config);
        } else {
            $answer = ipGridController($config);
        }

        return $answer;
    }

//    /**
//     * @ipSubmenu Settings
//     */
//    public function settings()
//    {
//        $url = ipActionUrl(array('aa' => 'Plugins.index', 'disableAdminNavbar' => 1));
//        $url .= '#/hash=&plugin=SimpleProduct';
//        //return new \Ip\Response\Redirect($url);
//        return '<iframe style="margin-left: -300px; width: 600px; height: 300px;" src="' . $url . '"></iframe>';
//    }


    public function widgetPopupForm()
    {
        $widgetId = ipRequest()->getQuery('widgetId');

        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        $form = FormHelper::widgetEditForm($widgetData);

        $popup = ipView('view/editPopup.php', array('form' => $form))->render();
        $data = array(
            'popup' => $popup
        );
        return new \Ip\Response\Json($data);

    }


    /**
     * Update widget data
     *
     * This method is executed each time the widget data is updated.
     *
     * @param int $widgetId Widget ID
     * @param array $postData
     * @param array $currentData
     * @return array Data to be stored to the database
     */
    public function update($widgetId, $postData, $currentData)
    {
        if (is_array($currentData['images'])) {
            foreach($currentData['images'] as $image) {
                ipUnbindFile($image, 'SimpleProduct', $widgetId);
            }
        }
        if (is_array($postData['images'])) {
            foreach($postData['images'] as $image) {
                ipBindFile($image, 'SimpleProduct', $widgetId);
            }
        }
        return $postData;
    }



}
