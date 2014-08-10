<?php echo ipRenderWidget('Heading', array('title' => __('Order completed', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => __('We have just got the payment. Your goods will be shipped as soon as possible. Thank You!', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Heading', array('level' => 2, 'title' => __('Order details', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => ipView('helper/orderStatus.php', $this->getVariables()))) ?>
