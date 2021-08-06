define([
    'jquery',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data'
], function ($, getTotalsAction, customerData) {

        $('.action.action-delete').on('click',function () {
        var id = this.dataset.post;
        var formKey = $("input[name='form_key']").val();
        var clear = this;
        $.ajax({
            url: 'http://mag.loc/checkout/cart/delete/',
            data: {'form_key':formKey, 'id':id,},
            method: 'post',
            showLoader: true,
            success: function (res) {
                var sections = ['cart'];
                customerData.reload(sections, true);
                $(clear).closest("tbody").css('display','none');
            },
            error: function (xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
            }
        });
    });
});

