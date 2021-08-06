define([
    'jquery',
    'Magento_Checkout/js/checkout-data',
    'Magento_Ui/js/modal/confirm',
    'ko',
    'Magento_Checkout/js/model/payment/additional-validators',
    'Magento_Checkout/js/action/redirect-on-success'
], function ($, checkoutData, confirmation, ko, additionalValidators,redirectOnSuccessAction) {
    'use strict';
    return function (target) {
        return target.extend({
            /**
             * @inheritdoc
             */
            placeOrder: function (data, event) {
                let self = this;
                var confirm =  {
                    oservable: ko.observable(false)
                };
                confirmation({
                    title: $.mage.__('Вы уверены что хотите выбрать именно этот метод оплаты?'),
                    content: $.mage.__('Выбраный метод ' + checkoutData.getSelectedPaymentMethod()+'!'),
                    buttons: [{
                        text: $.mage.__('Отмена'),
                        class: 'action-secondary action-dismiss',
                        click: function (event) {
                            this.closeModal(event);
                        }
                    }, {
                        text: $.mage.__('Подтвердить'),
                        class: 'action-primary action-accept',
                        click: function (event) {
                            this.closeModal(event, true);
                            confirm.oservable(true);
                        }
                    }]
                });

                confirm.oservable.subscribe(function (bool) {
                    if (event) {
                        event.preventDefault();
                    }

                    if (self.validate() &&
                        additionalValidators.validate() &&
                        self.isPlaceOrderActionAllowed() === true
                    ) {
                        self.isPlaceOrderActionAllowed(false);

                        self.getPlaceOrderDeferredObject()
                            .done(
                                function () {
                                    self.afterPlaceOrder();

                                    if (self.redirectAfterPlaceOrder) {
                                        redirectOnSuccessAction.execute();
                                    }
                                }
                            ).always(
                            function () {
                                self.isPlaceOrderActionAllowed(true);
                            }
                        );

                        return true;
                    }

                    return false;
                })
            }
        });
    };
});
