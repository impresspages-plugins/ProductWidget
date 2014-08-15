<table>
    <tr>
        <td><b><?php echo __('Order ID', 'PayPal') ?></b></td>
        <td><?php echo esc($order['id']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Item', 'PayPal') ?></b></td>
        <td><?php echo esc($order['title']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Price', 'PayPal') ?></b></td>
        <td><?php echo esc(ipFormatPrice($order['price'], $order['currency'], 'PayPal')) ?></td>
    </tr>
<?php if ($order['type'] == 'physical') { ?>
    <tr>
        <td><b><?php echo __('Delivery cost', 'PayPal') ?></b></td>
        <td><?php echo esc(ipFormatPrice($order['deliveryCost'], $order['currency'], 'PayPal')) ?></td>
    </tr>
<?php } ?>
    <tr>
        <td><b><?php echo __('Date', 'PayPal') ?></b></td>
        <td><?php echo esc(ipFormatDateTime(strtotime($order['createdAt']), 'PayPal')) ?></td>
    </tr>
</table>
