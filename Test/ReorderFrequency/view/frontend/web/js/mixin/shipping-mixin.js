define(
    [
        'jquery',
        'ko'
    ], function (
        $,
        ko
    ) {
        'use strict';

        return function (target) {
            return target.extend({
                setShippingInformation: function () {
                    if (this.validateReorderFrequency()) {
                        this._super();
                    }
                },
                validateReorderFrequency: function() {
                    this.source.set('params.invalid', false);
                    this.source.trigger('reorder_frequency.data.validate');

                    if (this.source.get('params.invalid')) {
                        return false;
                    }

                    return true;
                }
            });
        }
    }
);