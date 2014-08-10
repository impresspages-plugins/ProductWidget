<?php echo ipRenderWidget('Heading', array('title' => __('Order completed', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => __('Thank You for being with us! ', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Heading', array('level' => 2, 'title' => __('Order details', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => ipView('helper/orderStatus.php', $this->getVariables()))) ?>

