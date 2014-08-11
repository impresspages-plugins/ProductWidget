<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.7.19
 * Time: 19.44
 */

namespace Plugin\SimpleProduct;


class FormHelper
{
    public static function widgetEditForm($widgetData)
    {
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
                    'name' => 'alias',
                    'label' => __( 'Alias (unique identificator)', 'SimpleProduct', false ),
                    'value' => empty($widgetData['alias']) ? null : $widgetData['alias']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Currency(
                array(
                    'name' => 'price',
                    'label' => __( 'Price', 'SimpleProduct', false ),
                    'value' => empty($widgetData['price']) ? null : $widgetData['price'],
                    'validators' => array('Required', array('Regex', '/^[A-Z][A-Z][A-Z]$/'))
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'currency',
                    'label' => __( 'Currency', 'SimpleProduct', false ),
                    'value' => empty($widgetData['currency']) ? null : $widgetData['currency'],
                    'hint' => __('Three uppercase letter code. Eg. USD', 'SimpleProduct', false)
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
                    'label' => __( 'Require user registlration', 'SimpleProduct', false ),
                    'value' => empty($widgetData['requireLogin']) ? null : $widgetData['requireLogin']
                )
            )
        );



        $form->addField(new \Ip\Form\Field\Url(
                array(
                    'name' => 'successUrl',
                    'label' => __( 'Page after successful payment', 'SimpleProduct', false ),
                    'value' => empty($widgetData['successUrl']) ? null : $widgetData['successUrl'],
                    'note' => __( 'Leave empty for default', 'SimpleProduct', false ),
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
                    'label' => __( 'Product type', 'SimpleProduct', false),
                    'value' => empty($widgetData['type']) ? null : $widgetData['type']
                )
            )
        );


        $form->addField(new \Ip\Form\Field\Info(
                array(
                    'layout' => \Ip\Form\Field::LAYOUT_NO_LABEL,
                    'name' => 'deliveryRates',
                    'html' => '<div><a target="_blank" href="'. ipActionUrl(array('aa' => 'SimpleProduct.countries')) .'">' . __('Delivery rates', 'SimpleProduct') . '</a></div>'
                )
            )
        );


        $form->addField(new \Ip\Form\Field\RepositoryFile(
                array(
                    'secure' => true,
                    'label' => __( 'File on sale', 'SimpleProduct', false),
                    'name' => 'fileOnSale',
                    'value' => empty($widgetData['fileOnSale']) ? null : $widgetData['fileOnSale']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'fileOnSaleName',
                    'label' => __( 'File name while downloading', 'SimpleProduct', false ),
                    'value' => empty($widgetData['fileOnSaleName']) ? null : $widgetData['fileOnSaleName'],
                    'note' => __('Leave empty to use the same name as you have uploaded', 'SimpleProduct', false)
                )
            )
        );


        return $form;
    }

    public static function downloadableProductOrderForm($widgetId)
    {
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);

        $form->addClass('ipsDownloadableProductForm downloadableProductForm');

        $defaultData = array();
        if (ipUser()->loggedIn()) {
            $defaultData = ipUser()->data();
        }
        $defaultData = ipFilter('SimpleProduct_downloadableProductOrderFormDefaults', $defaultData);

        $form->addField(new \Ip\Form\Field\Hidden(
                array(
                    'name' => 'widgetId',
                    'value' => $widgetId,
                    'validators' => array('Required')
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Hidden(
                array(
                    'name' => 'sa',
                    'value' => 'SimpleProduct.pay'
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'name',
                    'label' => __( 'Full name', 'SimpleProduct', false ),
                    'value' => empty($defaultData['name']) ? null : $defaultData['name'],
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'telephone',
                    'label' => __( 'Telephone', 'SimpleProduct', false ),
                    'value' => empty($defaultData['telephone']) ? null : $defaultData['telephone']
                )
            )
        );


        $form->addField(new \Ip\Form\Field\Email(
                array(
                    'name' => 'email',
                    'label' => __( 'Email', 'SimpleProduct', false ),
                    'value' => empty($defaultData['email']) ? null : $defaultData['email'],
                    'validators' => array('Required')
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Submit(
                array(
                    'name' => 'submit',
                    'value' => __( 'Proceed', 'SimpleProduct', false )
                )
            )
        );

        $form = ipFilter('SimpleProduct_downloadableProductOrderForm', $form);
        return $form;

    }

    public static function virtualProductOrderForm($widgetId)
    {
        $form = new \Ip\Form();
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);

        $form->addClass('ipsVirtualProductForm virtualProductForm');

        $defaultData = array();
        if (ipUser()->loggedIn()) {
            $defaultData = ipUser()->data();
        }
        $defaultData = ipFilter('SimpleProduct_virtualProductOrderFormDefaults', $defaultData);

        $form->addField(new \Ip\Form\Field\Hidden(
                array(
                    'name' => 'widgetId',
                    'value' => $widgetId,
                    'validators' => array('Required')
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Hidden(
                array(
                    'name' => 'sa',
                    'value' => 'SimpleProduct.pay'
                )
            )
        );


        $form->addField(new \Ip\Form\Field\Submit(
                array(
                    'name' => 'submit',
                    'value' => __( 'Proceed', 'SimpleProduct', false )
                )
            )
        );

        $fieldCount = count($form->getFields());

        $form = ipFilter('SimpleProduct_virtualProductOrderForm', $form);

        if ($fieldCount == count($form->getFields())) {
            //empty form. Autosubmit
            $form->addClass('ipsProductWidgetAutosubmit');
        }

        return $form;

    }

    public static function physicalProductOrderForm($widgetId)
    {
        $widget = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widget['data'];



        $form = new \Ip\Form();

        $form->setEnvironment(\Ip\Form::ENVIRONMENT_PUBLIC);

        $form->addClass('ipsPhysicalProductForm physicalProductForm');

        $defaultData = array();
        if (ipUser()->loggedIn()) {
            $defaultData = ipUser()->data();
        }
        $defaultData = ipFilter('SimpleProduct_physicalProductOrderFormDefaults', $defaultData);

        $form->addFieldset(new \Ip\Form\Fieldset(__('Contact data', 'SimpleProduct', false)));

        $form->addField(new \Ip\Form\Field\Hidden(
                array(
                    'name' => 'widgetId',
                    'value' => $widgetId,
                    'validators' => array('Required')
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Hidden(
                array(
                    'name' => 'sa',
                    'value' => 'SimpleProduct.pay'
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'name',
                    'label' => __( 'Full name', 'SimpleProduct', false ),
                    'value' => empty($defaultData['name']) ? null : $defaultData['name'],
                    'validators' => array('Required')
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'telephone',
                    'label' => __( 'Telephone', 'SimpleProduct', false ),
                    'value' => empty($defaultData['telephone']) ? null : $defaultData['telephone']
                )
            )
        );


        $form->addField(new \Ip\Form\Field\Email(
                array(
                    'name' => 'email',
                    'label' => __( 'Email', 'SimpleProduct', false ),
                    'value' => empty($defaultData['email']) ? null : $defaultData['email'],
                    'validators' => array('Required')
                )
            )
        );

        $form->addFieldset(new \Ip\Form\Fieldset(__('Delivery', 'SimpleProduct', false)));

        $countries = CountryModel::getCountryList();

        $form->addField(new \Ip\Form\Field\Select(
                array(
                    'name' => 'country',
                    'label' => __( 'Country', 'SimpleProduct', false ),
                    'values' => $countries,
                    'value' => empty($defaultData['country']) ? null : $defaultData['country'],
                    'validators' => array('Required'),
                    'css' => 'ipsCountry'
                )
            )
        );


        $form->addField(new \Ip\Form\Field\Textarea(
                array(
                    'name' => 'address',
                    'label' => __( 'Address', 'SimpleProduct', false ),
                    'value' => empty($defaultData['address']) ? null : $defaultData['address'],
                    'validators' => array('Required')
                )
            )
        );

        $defaultCountry = CountryModel::getDefaultCountry();
        $orderCurrency = $widgetData['currency'];
        $deliveryPrice = ipConvertCurrency($defaultCountry['deliveryCost'], $defaultCountry['currency'], $orderCurrency);
        if ($deliveryPrice == false) {
            $deliveryPrice = $defaultCountry['deliveryCost'];
        }
        $form->addField(new \Ip\Form\Field\Info(
                array(
                    'name' => 'cost',
                    'label' => __( 'Delivery price', 'SimpleProduct', false ),
                    'html' => ipView('view/costField.php', array('cost' => $deliveryPrice, 'currency' => $orderCurrency)),
                )
            )
        );



        $form->addField(new \Ip\Form\Field\Submit(
                array(
                    'name' => 'submit',
                    'value' => __( 'Proceed', 'SimpleProduct', false )
                )
            )
        );


        $form = ipFilter('SimpleProduct_physicalProductOrderForm', $form);
        return $form;
    }
}
