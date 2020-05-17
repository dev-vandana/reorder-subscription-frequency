<?php
namespace Test\ReorderFrequency\Plugin\Checkout\Block;

class LayoutProcessor
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shippingAdditional'] = [
            'component' => 'uiComponent',
            'displayArea' => 'shippingAdditional',
            'children' => [
                'reorder_frequency' => [
                    'component' => 'Test_ReorderFrequency/js/view/reorder-frequency-block',
                    'displayArea' => 'reorder-frequency-block',
                    'deps' => 'checkoutProvider',
                    'dataScopePrefix' => 'reorder_frequency',
                    'children' => [
                        'form-fields' => [
                            'component' => 'uiComponent',
                            'displayArea' => 'reorder-frequency-block',
                            'children' => [
                                'reorder_frequency' => [
                                    'component' => 'Test_ReorderFrequency/js/view/reorder-frequency',
                                    'config' => [
                                        'customScope' => 'reorder_frequency',
                                        'template' => 'ui/form/field',
                                        'elementTmpl' => 'Test_ReorderFrequency/fields/reorder-frequency',
                                        'id' => 'reorder_frequency'
                                    ],
                                    'dataScope' => 'reorder_frequency.reorder_frequency',
                                    'label' => 'Reorder Frequency',
                                    'provider' => 'checkoutProvider',
                                    'visible' => true,
                                    'sortOrder' => 10,
                                    'id' => 'reorder_frequency'
                                ]
                            ],
                        ],
                    ]
                ]
            ]
        ];

        return $jsLayout;
    }
}