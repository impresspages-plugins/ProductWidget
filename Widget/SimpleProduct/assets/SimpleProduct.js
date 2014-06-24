/**
 * @package ImpressPages
 *
 */

var IpWidget_SimpleProduct = function () {

    this.widgetObject = null;
    this.confirmButton = null;
    this.popup = null;
    this.data = {};

    this.init = function (widgetObject, data) {

        this.widgetObject = widgetObject;
        this.data = data;

        var container = this.widgetObject.find('.ipsContainer');


        var context = this; // set this so $.proxy would work below


        this.$widgetOverlay = $('<div></div>');
        this.widgetObject.prepend(this.$widgetOverlay);
        this.$widgetOverlay.on('click', $.proxy(openPopup, this));

        $(document).on('ipWidgetResized', function () {
            $.proxy(fixOverlay, context)();
        });
        $(window).on('resize', function () {
            $.proxy(fixOverlay, context)();
        });
        $.proxy(fixOverlay, context)();


        ipInitForms();

        container.css('min-height', '30px');
    };


    var fixOverlay = function () {
        this.$widgetOverlay
            .css('position', 'absolute')
            .css('z-index', 1000) // should be higher enough but lower than widget controls
            .width(this.widgetObject.width())
            .height(this.widgetObject.height());
    }


    this.onAdd = function () {
        $.proxy(openPopup, this)();
    };

    var openPopup = function () {
        $('#ipWidgetSimpleProductPopup').remove(); //remove any existing popup.

        var data = {
            aa: 'ProductWidget.widgetPopupForm',
            securityToken: ip.securityToken,
            widgetId: this.widgetObject.data('widgetId')
        }

        $.ajax({
            url: ip.baseUrl,
            data: data,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                //create new popup
                var $popupHtml = $(response.popup);
                $('body').append($popupHtml);
                this.popup = $('#ipWidgetSimpleProductPopup .ipsModal');
                this.popup.modal();
                ipInitForms();
            },
            error: function (response) {
                alert('Error: ' + response.responseText);
            }
        });




//        this.confirmButton = this.popup.find('.ipsConfirm');
//        this.title = this.popup.find('input[name=]');
//        this.price = this.popup.find('input[name=]');
//        this.currency = this.popup.find('input[name=]');
//        this. = this.popup.find('input[name=]');
//        this. = this.popup.find('input[name=]');
//
//        if (this.data.html) {
//            this.textarea.val(this.data.html);
//        } else {
//            this.textarea.val(''); // cleanup value if it was set before
//        }
//
//        this.popup.modal(); // open modal popup
//
//        this.confirmButton.off(); // ensure we will not bind second time
//        this.confirmButton.on('click', $.proxy(save, this));
    };

    var save = function () {
        var data = {
            html: this.textarea.val()
        };

        this.widgetObject.save(data, 1); // save and reload widget
        this.popup.modal('hide');
    };

};

