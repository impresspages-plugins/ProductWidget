<?php echo ipRenderWidget('Heading', array('title' => __('Order completed', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => __('You can start downloading straight away. Thank You!', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => '<a href="' . escAttr($downloadUrl) . '"><span class="button">' . __('Download', 'SimpleProduct') . '</span></a>')) ?>
<?php echo ipRenderWidget('Heading', array('level' => 2, 'title' => __('Order details', 'SimpleProduct', false))) ?>
<?php echo ipRenderWidget('Text', array('text' => ipView('helper/orderStatus.php', $this->getVariables()))) ?>
