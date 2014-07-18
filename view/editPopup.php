<div class="ip" id="ipWidgetSimpleProductPopup">
    <div class="modal fade ipsModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php _e('Product info', 'ProductWidget'); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo $form->render() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel', 'ProductWidget'); ?></button>
                    <button type="button" class="btn btn-primary ipsConfirm"><?php _e('Confirm', 'ProductWidget'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
