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

namespace Plugin\SimpleProduct\Widget\SimpleProduct;


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
        return __('Product', 'SimpleProduct', false);
    }


    /**
     * Renders widget's HTML output
     *
     * You can extend this method when generating widget's HTML.
     *
     * @param int $revisionId Widget revision ID
     * @param int $widgetId Widget ID
     * @param int $widgetId Widget instance ID
     * @param array $data Widget data array
     * @param string $skin Skin name
     * @return string Widget's HTML code
     */

    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        $imageOptions = array(
            'type' => 'width',
            'width' => ipGetOption('SimpleProduct.imageWidth', 400),
            //'height' => ipGetOption('SimpleProduct.imageHeight', 1000),
            'forced' => true //smaller images will be scaled up if set to true
        );

        $lightboxOptions = array(
            'type' => 'fit',
            'width' => ipGetOption('Config.lightboxWidth', 800),
            'height' => ipGetOption('Config.lightboxHeight', 600)
        );

        $thumbOptions = array(
            'type' => 'center',
            'width' => ipGetOption('SimpleProduct.imagesWidth', 50),
            'height' => ipGetOption('SimpleProduct.imagesHeight', 40),
            //'height' => ipGetOption('SimpleProduct.imageHeight', 1000),
            'forced' => true //smaller images will be scaled up if set to true
        );

        if (!isset($data['title'])) {
            $data['title'] = '';
        }
        if (!isset($data['description'])) {
            $data['description'] = '';
        }
        if (!isset($data['currency'])) {
            $data['currency'] = 'USD';
        }

        if (empty($data['images']) || !is_array($data['images'])) {
            $data['images'] = array();
        }
        $data['originalImages'] = $data['images'];

        if (!empty($data['originalImages'][0])) {
            $data['image'] = ipFileUrl(ipReflection($data['originalImages'][0], $imageOptions));
            $data['imageBig'] = ipFileUrl(ipReflection($data['originalImages'][0], $lightboxOptions));

        } else {
            $data['image'] = '';
            $data['imageBig'] = '';
        }

        $data['images'] = array();
        $data['imagesBig'] = array();
        foreach($data['originalImages'] as $key => $image) {
            if ($key == 0) {
                continue; //skip first image;
            }
            $data['images'][] = ipFileUrl(ipReflection($image, $thumbOptions));

            $data['imagesBig'][] = ipFileUrl(ipReflection($image, $lightboxOptions));
        }

        $data['widgetId'] = $widgetId;
        $data['checkoutUrl'] = ipRouteUrl('SimpleProduct_checkout', array('widgetId' => $widgetId));

        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
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
        if (!empty($currentData['images']) && is_array($currentData['images'])) {
            foreach($currentData['images'] as $image) {
                ipUnbindFile($image, 'SimpleProduct', $widgetId);
            }
        }
        if (!empty($postData['images']) && is_array($postData['images'])) {
            foreach($postData['images'] as $image) {
                ipBindFile($image, 'SimpleProduct', $widgetId);
            }
        }

        if (!empty($currentData['fileOnSale']) && is_array($currentData['fileOnSale'])) {
            foreach($currentData['fileOnSale'] as $file) {
                ipUnbindFile($file, 'SimpleProduct', $widgetId, 'file/secure/');
            }
        }
        if (!empty($postData['fileOnSale']) && is_array($postData['fileOnSale'])) {
            foreach($postData['fileOnSale'] as $file) {
                ipBindFile($file, 'SimpleProduct', $widgetId, 'file/secure/');
            }
        }


        return $postData;
    }

}
