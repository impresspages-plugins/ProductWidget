<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.6.30
 * Time: 19.26
 */

namespace Plugin\SimpleProduct;


use Ip\Page;

class SiteController
{
    public function checkout($widgetId)
    {
        $widget = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        if (!$widget) {
            throw new \Ip\Exception('Missing required variable');
        }
        $widgetData = $widget['data'];

        if (!empty($widgetData['requireLogin']) && !ipUser()->loggedIn()) {
            $activePlugins = \Ip\Internal\Plugins\Service::getActivePluginNames();
            if (!in_array('User', $activePlugins)) {
                throw new \Ip\Exception("Please install User plugin");
            }
            return new \Ip\Response\Json(array('redirectUrl' => ipRouteUrl('User_login')));
        }


        if (empty($widgetData['type'])) {
            return __('Please set product type in product widget settings.', 'SimpleProduct');
        }

        switch($widgetData['type']) {
            case 'physical':
                $countries = CountryModel::getCountryList();
                if (empty($countries)) {
                    return __('At least one country has to be set in <a href="' . ipActionUrl(array('aa' => 'SimpleProduct.countries')) . '">SimpleProduct plugin</a>.', 'SimpleProduct', false);
                }
                return $this->physicalProductOrderForm($widgetId);
                break;
            case 'downloadable':
                return $this->downloadableProductOrderForm($widgetId);
                break;
            case 'virtual':
                return $this->virtualProductOrderForm($widgetId);
                break;
        }

    }

    public function pay()
    {
        $widgetId = ipRequest()->getPost('widgetId');
        $widget = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        if (!$widget) {
            throw new \Ip\Exception('Missing required variable');
        }
        $widgetData = $widget['data'];

        if (!empty($widgetData['requireLogin']) && !ipUser()->loggedIn()) {
            $activePlugins = \Ip\Internal\Plugins\Service::getActivePluginNames();
            if (!in_array('User', $activePlugins)) {
                throw new \Ip\Exception("Please install User plugin");
            }
            return new \Ip\Response\Json(array('redirectUrl' => ipRouteUrl('User_login')));
        }


        if (empty($widgetData['type'])) {
            return __('Please set product type in product widget settings.', 'SimpleProduct');
        }

        switch($widgetData['type']) {
            case 'physical':
                $form = FormHelper::physicalProductOrderForm($widgetId);
                $errors = $form->validate(ipRequest()->getPost());
                if ($errors) {
                    return new \Ip\Response\Json(array('status' => 'error', 'errors' => $errors));
                }
                $orderData = $form->filterValues(ipRequest()->getPost());
                unset($orderData['securityToken']);
                unset($orderData['sa']);
                unset($orderData['antispam']);
                $orderData['currency'] = Model::getCurrency();
                $widgetDataKeys = array ('title' => 1, 'alias' => 1, 'type' => 1, 'description' => 1, 'price' => 1);
                $viableWidgetData = array_intersect_key($widgetData, $widgetDataKeys);
                $orderData = array_merge($orderData, $viableWidgetData); //merging vice may open a security hole to change the price via checkout
                $country = CountryModel::getCountryByTitle($orderData['country']);
                if (!$country) {
                    throw new \Ip\Exception('Country not found');
                }
                $orderData['deliveryCost'] = $country['deliveryCost'];

                $orderId = OrderModel::create($orderData);
                $paymentOptions = array (
                    ''
                );
                ipEcommerce()->paymentUrl($paymentOptions);


                break;
            case 'downloadable':
                $form = FormHelper::downloadableProductOrderForm($widgetId);
                $errors = $form->validate(ipRequest()->getPost());
                if ($errors) {
                    return new \Ip\Response\Json(array('status' => 'error', 'errors' => $errors));
                }
                $orderData = $form->filterValues(ipRequest()->getPost());
                unset($orderData['securityToken']);
                unset($orderData['sa']);
                unset($orderData['antispam']);
                $orderData['currency'] = Model::getCurrency();
                $widgetDataKeys = array ('title' => 1, 'alias' => 1, 'type' => 1, 'description' => 1, 'price' => 1);
                $viableWidgetData = array_intersect_key($widgetData, $widgetDataKeys);
                $orderData = array_merge($orderData, $viableWidgetData); //merging vice may open a security hole to change the price via checkout
                $orderData['deliveryCost'] = null;

                $orderId = OrderModel::create($orderData);
                $paymentOptions = array (
                    ''
                );
                ipEcommerce()->paymentUrl($paymentOptions);

                break;
            case 'virtual':
                $form = FormHelper::virtualProductOrderForm($widgetId);
                $errors = $form->validate(ipRequest()->getPost());
                if ($errors) {
                    return new \Ip\Response\Json(array('status' => 'error', 'errors' => $errors));
                }
                $orderData = $form->filterValues(ipRequest()->getPost());
                unset($orderData['securityToken']);
                unset($orderData['sa']);
                unset($orderData['antispam']);
                $orderData['currency'] = Model::getCurrency();
                $widgetDataKeys = array ('title' => 1, 'alias' => 1, 'type' => 1, 'description' => 1, 'price' => 1);
                $viableWidgetData = array_intersect_key($widgetData, $widgetDataKeys);
                $orderData = array_merge($orderData, $viableWidgetData); //merging vice may open a security hole to change the price via checkout
                $orderData['deliveryCost'] = null;

                $orderId = OrderModel::create($orderData);
                $paymentOptions = array (
                    'item' => $orderData['title'],
                    'price' => $orderData['price'],
                    'currency' => $orderData['currency']
                );
                return new \Ip\Response\Json(array(
                    'status' => 'success',
                    'redirectUrl' => ipEcommerce()->paymentUrl($paymentOptions)
                ));
                break;
        }

    }


    public function updateDeliveryCost()
    {
        $countryTitle = ipRequest()->getQuery('country');
        $country = CountryModel::getCountryByTitle($countryTitle);
        if (!$country) {
            throw new \Ip\Exception('Country doesn\'t exist: ' . $countryTitle);
        }
        $viewData = array(
            'cost' => $country['deliveryCost'],
            'currency' => Model::getCurrency()
        );
        $html = ipView('view/costField.php', $viewData)->render();
        $response = array(
            'status' => 'success',
            'html' => $html
        );
        return new \Ip\Response\Json($response);


    }

    protected function physicalProductOrderForm($widgetId)
    {
        $viewData = array (
            'form' => FormHelper::physicalProductOrderForm($widgetId)
        );
        $pageView = ipView('view/page/physicalProductOrderForm.php', $viewData);
        return $pageView;
    }

    protected function downloadableProductOrderForm($widgetId)
    {
        $viewData = array (
            'form' => FormHelper::downloadableProductOrderForm($widgetId)
        );
        $pageView = ipView('view/page/physicalProductOrderForm.php', $viewData);
        return $pageView;
    }

    protected function virtualProductOrderForm($widgetId)
    {
        $viewData = array (
            'form' => FormHelper::virtualProductOrderForm($widgetId)
        );
        $pageView = ipView('view/page/virtualProductOrderForm.php', $viewData);
        return $pageView;
    }

}
