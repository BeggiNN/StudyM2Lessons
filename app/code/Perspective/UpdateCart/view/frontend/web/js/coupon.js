define([
    'jquery',
    'Magento_Checkout/js/model/cart/cache',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data'
], function ($, cache, getTotalsAction, customerData) {
    var form = $('#discount-coupon-form');
    $(form).submit(function (e) {
        e.preventDefault();
    });
    $('.action.apply.primary').on('click',function () {
        $.ajax(
            {
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (response) {
                    $('#discount-coupon-form').hide();
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred);
                    cache.clear('cartVersion');
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            }
        );
    });
    $('.action.cancel.primary').on('click',function () {
        $.ajax(
            {
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (response) {
                    $('#discount-coupon-form').hide();
                    cache.clear('cartVersion');
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred);
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            }
        );
    });
});
