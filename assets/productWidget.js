$( document ).ready(function() {
    "use strict";
    $('.ipsPhysicalProductForm .ipsCountry').on('change', function (e) {

        var data = {
            'sa': 'SimpleProduct.updateDeliveryCost',
            'country': $(this).val()
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
});
