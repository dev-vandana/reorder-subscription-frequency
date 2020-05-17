define([
    'jquery',
    'ko',
    'Magento_Ui/js/form/element/abstract'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        initObservable: function () {

            this._super()
                .observe([
                    'customOptionValue'
                ]);
            return this;
        },
        getCustomOption: function() {
            return _.map(window.checkoutConfig.shipping.reorder_frequency.customOptionValue, function(value, key) {
                return {
                    'value': key,
                    'label': value
                }
            });
        }
    });
});