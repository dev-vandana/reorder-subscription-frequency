var config = {
    "map": {
        "*": {
            'Magento_Checkout/js/model/shipping-save-processor/default': 'Test_ReorderFrequency/js/model/shipping-save-processor/default'
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'Test_ReorderFrequency/js/mixin/shipping-mixin': true
            }
        }
    }
};