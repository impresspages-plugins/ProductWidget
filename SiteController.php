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
                break;
        }
        $orderId = OrderModel::create($orderData);
        $order = OrderModel::get($orderId);


        if (!empty($widgetData['successUrl'])) {
            $successUrl = $widgetData['successUrl'];
        } else {
            $successUrl = ipRouteUrl('SimpleProduct_completed', array('orderId' => $orderId, 'securityCode' => $order['securityCode']));
        }

        $paymentOptions = array (
            'id' => $orderId,
            'title' => $orderData['title'],
            'price' => $orderData['price'] * 100,
            'currency' => $orderData['currency'],
            'successUrl' => $successUrl,
        );
        $paymentUrl = ipEcommerce()->paymentUrl($paymentOptions);
        return new \Ip\Response\Json(array(
                'status' => 'success',
                'redirectUrl' => $paymentUrl
            ));

    }

    public function download($orderId, $securityCode)
    {
        $order = OrderModel::get($orderId);
        if (!$order) {
            throw new \Ip\Exception('Order doesn\'t exist.');
        }
        if ($order['securityCode'] != $securityCode) {
            throw new \Ip\Exception('Incorrect security code');
        }

        $file = ipFile('secure/' . $order['fileOnSale']);

        if (strpos(realpath($file), realpath(ipFile('secure/'))) !== 0) {
            throw new \Ip\Exception("Trying to access file outside of secure dir.");
        }

        $requiredName = basename($file);
        if (!empty($order['fileOnSaleName'])) {
            $requiredName = $order['fileOnSaleName'];
        }

        // get mime type
        $mtype = "application/force-download";

        $fsize = filesize($file);
        // set headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: $mtype");
        header("Content-Disposition: attachment; filename=\"" . escAttr($requiredName) . "\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);

        // download
        // @readfile($file_path);
        $file = @fopen($file, "rb");
        if ($file) {
            while (!feof($file)) {
                print(fread($file, 1024 * 8));
                flush();
                if (connection_status() != 0) {
                    @fclose($file);
                    die();
                }
            }
            @fclose($file);
        }
        return false;
    }

    public function completed($orderId, $securityCode)
    {
        $order = OrderModel::get($orderId);
        if (!$order) {
            throw new \Ip\Exception('Order doesn\'t exist.');
        }
        if ($order['securityCode'] != $securityCode) {
            throw new \Ip\Exception('Incorrect security code');
        }

        $response = '';
        switch($order['type']) {
            case 'virtual':
                $data = array(
                    'order' => $order
                );
                $response = ipView('view/page/virtualProductPurchased.php', $data);
                break;
            case 'physical':
                $data = array(
                    'order' => $order
                );
                $response = ipView('view/page/physicalProductPurchased.php', $data);
                break;
            case 'downloadable':
                $downloadUrl = ipRouteUrl('SimpleProduct_download', array('orderId' => $orderId, 'securityCode' => $securityCode));
                $data = array(
                    'order' => $order,
                    'downloadUrl' => $downloadUrl
                );
                $response = ipView('view/page/downloadableProductPurchased.php', $data);
                break;
        }

        $response = ipFilter('SimpleProduct_successfulPurchasePageResponse', $response, array('order' => $order));

        return $response;
    }

    public function canceled($orderId, $securityCode)
    {
        $order = OrderModel::get($orderId);
        if (!$order) {
            throw new \Ip\Exception('Order doesn\'t exist.');
        }
        if ($order['securityCode'] != $securityCode) {
            throw new \Ip\Exception('Incorrect security code');
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
