<p><?php echo ipReplacePlaceholders(__('Thank You for purchasing on {websiteTitle}. Your order is being processed now.', 'SimpleProduct')) ?></p>
<h2><?php echo __('Order details', 'SimpleProduct') ?></h2>
<?php echo ipRenderWidget('Text', array('text' => ipView('helper/orderStatus.php', $this->getVariables()))) ?>
