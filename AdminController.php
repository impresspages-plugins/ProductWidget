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

namespace Plugin\ProductWidget;


class AdminController
{
    public function widgetPopupForm()
    {
        $widgetId = ipRequest()->getQuery('widgetId');

        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        $form = new \Ip\Form();

        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);


        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'title',
                    'label' => __( 'Title', 'SimpleProduct', false ),
                    'value' => empty($widgetData['title']) ? null : $widgetData['title']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'price',
                    'label' => __( 'Price', 'SimpleProduct', false ),
                    'value' => empty($widgetData['price']) ? null : $widgetData['price']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'currency',
                    'label' => __( 'Currency (eg. USD)', 'SimpleProduct', false ),
                    'value' => empty($widgetData['currency']) ? null : $widgetData['currency']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\RepositoryFile(
                array(
                    'name' => 'images',
                    'label' => __( 'Images', 'SimpleProduct', false ),
                    'value' => empty($widgetData['images']) ? null : $widgetData['images']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\RichText(
                array(
                    'name' => 'description',
                    'label' => __( 'Description', 'SimpleProduct', false ),
                    'value' => empty($widgetData['description']) ? null : $widgetData['description']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Checkbox(
                array(
                    'name' => 'requireLogin',
                    'label' => __( 'Require user registration', 'SimpleProduct', false ),
                    'value' => empty($widgetData['requireLogin']) ? null : $widgetData['requireLogin']
                )
            )
        );

        $values = array(
            array('physical', __('Physical', 'SimpleProduct', false)),
            array('downloadable', __('Downloadable', 'SimpleProduct', false)),
            array('virtual', __('Virtual', 'SimpleProduct', false)),
        );
        $form->addField(new \Ip\Form\Field\Select(
                array(
                    'name' => 'type',
                    'values' => $values,
                    'label' => __( 'Product type', 'SimpleProduct', false ),
                    'value' => empty($widgetData['type']) ? null : $widgetData['type']
                )
            )
        );


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
                ipUnbindFile($image, 'ProductWidget', $widgetId);
            }
        }
        if (is_array($postData['images'])) {
            foreach($postData['images'] as $image) {
                ipBindFile($image, 'ProductWidget', $widgetId);
            }
        }
        return $postData;
    }
}
