<table>
    <tr>
        <td><b><?php echo __('Order ID', 'SimpleProduct') ?></b></td>
        <td><?php echo esc($order['id']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Item', 'SimpleProduct') ?></b></td>
        <td><?php echo esc($order['title']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Price', 'SimpleProduct') ?></b></td>
        <td><?php echo esc(ipFormatPrice($order['price'], $order['currency'], 'SimpleProduct')) ?></td>
    </tr>
<?php if ($order['type'] == 'physical') { ?>
    <tr>
        <td><b><?php echo __('Delivery cost', 'SimpleProduct') ?></b></td>
        <td><?php echo esc(ipFormatPrice($order['deliveryCost'], $order['currency'], 'SimpleProduct')) ?></td>
    </tr>
<?php } ?>
    <tr>
        <td><b><?php echo __('Date', 'SimpleProduct') ?></b></td>
        <td><?php echo esc(ipFormatDateTime(strtotime($order['createdAt']), 'SimpleProduct')) ?></td>
    </tr>
</table>
