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

namespace Plugin\ProductWidget;


class SiteController
{
    public function buy()
    {
        $widgetId = ipRequest()->getQuery('widgetId');
        $widget = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        if (!$widget) {
            throw new \Ip\Exception('Missing required variable');
        }
        $data = $widget['data'];

        if (!empty($data['requireLogin']) && !ipUser()->loggedIn()) {
            $activePlugins = \Ip\Internal\Plugins\Service::getActivePluginNames();
            if (!in_array('User', $activePlugins)) {
                throw new \Ip\Exception("Please install User plugin");
            }
            return new \Ip\Response\Json(array('redirectUrl' => ipRouteUrl('User_login')));
        }



    }
}
