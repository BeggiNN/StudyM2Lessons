define([
    'jquery',
    'Magento_Checkout/js/model/cart/cache',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data'
], function ($, cache, getTotalsAction, customerData) {

    $(document).ready(function(){
        $(document).on('change', 'input[name$="[qty]"]', function(){
            var form = $('form#form-validate');
            $.ajax({
                url: form.attr('action'),
                data: form.serialize(),
                showLoader: true,
                success: function (res) {
                    var parsedResponse = $.parseHTML(res);
                    var result = $(parsedResponse).find("#form-validate");
                    var sections = ['cart'];
                    $("#form-validate").replaceWith(result);
                    customerData.reload(sections, true);
                    var deferred = $.Deferred();
                    getTotalsAction([], deferred);
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
                }
            });
        });
    });
    $(document).on('click','.swatch-option',function () {
        if($(this).hasClass('text')){
            var product = $(this).data('product_id');
            let text = $(this).text();
            var optId = $('#93').val();
            var attrId = $('#93').data('attrName')
            var sizeAttrId = $(this).data('option_attribute_id');
            var sizeOptId = $(this).data('option_id');
            var colorAttrId = attrId;
            var colorOptId = optId;
            $('.swatch-attribute-selected-option-size-'+product).text(text);
            $('.text-product-'+product).removeClass('selected');
            $(this).addClass('selected');
        } else {
            var product = $(this).data('product_id')
            let colorText = $(this).data('option_inner_text');
            var colorAttrId = $(this).data('option_attribute_id');
            var colorOptId = $(this).data('option_id');
            var optId = $('#145').val();
            var attrId = $('#145').data('attrName')
            var sizeAttrId = attrId;
            var sizeOptId = optId;
            $('.swatch-attribute-selected-option-color-'+product).text(colorText);
            $('.color-product-'+product).removeClass('selected');
            $(this).addClass('selected');
        }
        var formKey = $("input[name='form_key']").val();
        let id = $('.action-delete').data('post');
        let qty = $('input[name$="[qty]"]').val();
        super_attribute = {};
        super_attribute[colorAttrId] = colorOptId;
        super_attribute[sizeAttrId] = sizeOptId;
        $.ajax({
            method: 'post',
            url: '/checkout/cart/updateItemOptions',
            data: {
                id: id,
                product: product,
                selected_configurable_option: "",
                related_product: "",
                form_key: formKey,
                super_attribute,
                qty: qty,
                item: id
            },
            showLoader: true,
            success: function (res) {
                cache.clear('cartVersion');
                var parsedResponse = $.parseHTML(res);
                var result = $(parsedResponse).find("#form-validate");
                var sections = ['cart'];
                $("#form-validate").replaceWith(result);
                customerData.reload(sections, true);
                var deferred = $.Deferred();
                getTotalsAction([], deferred);
            }
        });
    });
});
