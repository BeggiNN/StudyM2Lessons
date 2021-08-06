require([
    'jquery'
], function ($) {
    'use strict';
    $(document).ready(function(){
            $(document).on('click', 'input[name=product\\[allow_modify\\]]', function() {
                var checkbox = $('input[name=product\\[allow_modify\\]]').val();
                if (checkbox === "1") {
                    $('input[name=product\\[custom_price\\]]')
                        .prop("disabled",true);
                    $(".admin__field.admin__field-x-small_prices")
                        .addClass("_disabled");
                }else {
                    $('input[name=product\\[custom_price\\]]')
                        .prop("disabled",false);
                    $(".admin__field.admin__field-x-small_prices")
                        .removeClass("_disabled");
                }
            });
    });
});
