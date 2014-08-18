<?php echo ipRenderWidget('Heading', array('title' => __('Order completed', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => ipReplacePlaceholders(__('Thank You for purchasing on {websiteTitle}. Your order is being processed now.', 'SimpleProduct')))) ?>
<?php echo ipRenderWidget('Heading', array('level' => 2, 'title' => __('Order details', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => ipView('helper/orderStatus.php', $this->getVariables()))) ?>

