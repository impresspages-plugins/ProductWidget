<p><?php
echo ipReplacePlaceholders(
    __('Thank You for purchasing on {websiteTitle}. Follow the link to download purchased items <a href="{downloadUrl}">{downloadUrl}</a>', 'SimpleProduct', false),
    'SimpleProduct',
    array('downloadUrl' => $downloadUrl)
)
?></p>
<h2><?php echo __('Order details', 'SimpleProduct') ?></h2>
<?php echo ipRenderWidget('Text', array('text' => ipView('helper/orderStatus.php', $this->getVariables()))) ?>
