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
        $form = new \Ip\Form();

        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);


        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'title',
                    'label' => __( 'Title', 'SimpleProduct', false )
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'title',
                    'label' => __( 'Price', 'SimpleProduct', false )
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'currency',
                    'label' => __( 'Currency (eg. USD)', 'SimpleProduct', false )
                )
            )
        );

        $form->addField(new \Ip\Form\Field\RepositoryFile(
                array(
                    'name' => 'image',
                    'label' => __( 'Image', 'SimpleProduct', false ),
                    'fileLimit' => 1
                )
            )
        );

        $form->addField(new \Ip\Form\Field\RichText(
                array(
                    'name' => 'description',
                    'label' => __( 'Description', 'SimpleProduct', false )
                )
            )
        );

        $popup = ipView('view/editPopup.php', array('form' => $form))->render();
        $data = array(
            'popup' => $popup
        );
        return new \Ip\Response\Json($data);

    }
}
