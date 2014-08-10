<?php

 $routes['simpleproductcheckout/{widgetId}'] = array(
     'name' => 'SimpleProduct_checkout',
     'plugin' => 'SimpleProduct',
     'controller' => 'SiteController',
     'action' => 'checkout'
 );

$routes['simpleproductcheckout/completed/{orderId}/{securityCode}'] = array(
    'name' => 'SimpleProduct_completed',
    'plugin' => 'SimpleProduct',
    'controller' => 'SiteController',
    'action' => 'completed'
);
