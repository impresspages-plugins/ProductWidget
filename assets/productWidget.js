$( document ).ready(function() {
    "use strict";
    $('.ipWidget-SimpleProduct .ipsBuy').on('click', function (e) {
        e.preventDefault();

        var $buyButton = $(this);
        var widgetId = $buyButton.data('widgetid');
        var postData = {
            'sa': 'ProductWidget.buy',
            'widgetId': widgetId,
                'jsonrpc': '2.0'
        };

        $.ajax({
            url: ip.baseUrl,
            data: postData,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                if (response) {
                    if (response.redirectUrl) {
                        document.location = response.redirectUrl;
                    }
                }
            },
            error: function (response) {
                alert('Unexpected error.' + response.responseText);
            }
        });
    });
});
