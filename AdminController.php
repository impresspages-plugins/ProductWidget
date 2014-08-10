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
            'allowSort' => false,
            'orderBy' => 'priority, title',
            'fields' => array(
                array(
                    'label' => __('Title', 'SimpleProduct', false),
                    'field' => 'title',
                    'validators' => array('Required')
                ),
                array(
                    'type' => 'Currency',
                    'currency' =>  Model::getCurrency(),
                    'label' => __('Delivery cost', 'SimpleProduct', false) . ' (' . Model::getCurrency() . ')',
                    'field' => 'deliveryCost',
                    'validators' => array('Required')
                ),
                array(
                    'type' => 'Integer',
                    'label' => __('Priority (optional)', 'SimpleProduct', false),
                    'hint' => __('Set priority number to influence default alphabetical order.', 'SimpleProduct', false),
                    'field' => 'priority'
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
     * @ipSubmenu Settings
     */
    public function settings()
    {
        $url = ipActionUrl(array('aa' => 'Plugins.index'));
        $url .= '#/hash=&plugin=SimpleProduct';
        return new \Ip\Response\Redirect($url);
    }


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
