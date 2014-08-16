<?php echo ipRenderWidget('Heading', array('title' => __('Payment error', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => str_replace('[[order_id]]', $order['id'], __('We haven\'t got your payment yet. If you have chosen a payment method which takes some time to process, just relax and wait.
If you think the payment had to be done already, please contact us and give us this order ID [[order_id]]', 'SimpleProduct', false)))) ?>
