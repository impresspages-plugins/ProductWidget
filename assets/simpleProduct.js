$( document ).ready(function() {
    "use strict";

    //update delivery price when delivery country changes
    $('.ipsPhysicalProductForm .ipsCountry').on('change', function (e) {

        var data = {
            'sa': 'SimpleProduct.updateDeliveryCost',
            'country': $(this).val(),
            'widgetId': $(this).closest('form').find('input[name=widgetId]').val()
        };

        $.ajax({
            url: ip.baseUrl,
            data: data,
            dataType: 'json',
            type: 'GET',
            success: function (response) {
                $('.ipsPhysicalProductForm .ipsDeliveryCostHtml').replaceWith(response.html);
            },
            error: function (response) {
                alert('Unexpected error.' + response.responseText);
            }
        });
    });

    //autosubmit virtual product checkout form as virtual form has nothing needed to be entered.
    $('.ipsProductWidgetAutosubmit').submit();

});
