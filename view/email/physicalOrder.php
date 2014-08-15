<p><?php __('Thank You for purchasing on [[website_title]]. Your order is being processed now.', 'SimpleProduct') ?></p>
<h2><?php __('Order details', 'SimpleProduct') ?></h2>
<?php echo ipRenderWidget('Text', array('text' => ipView('helper/orderStatus.php', $this->getVariables()))) ?>
