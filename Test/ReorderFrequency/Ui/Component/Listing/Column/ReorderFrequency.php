<?php

namespace Test\ReorderFrequency\Ui\Component\Listing\Column;

use \Magento\Sales\Model\OrderFactory;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use Test\ReorderFrequency\Model\Config;

class ReorderFrequency extends Column
{
    protected $_orderRepository;
    protected $_config;

    public function __construct(
        ContextInterface $context, 
        UiComponentFactory $uiComponentFactory, 
        OrderFactory $orderRepository,
        Config $config,
        array $components = [], 
        array $data = []
    ){
        $this->_orderRepository = $orderRepository;
        $this->_config  = $config;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                $order  = $this->_orderRepository->create()->load($item["entity_id"]);
                $options = $this->_config->getCustomOptionValue();
                $value = '-';
                if( !empty($order->getData("reorder_frequency")) ){
                    $value = $options[$order->getData("reorder_frequency")];
                }

                $item[$this->getData('name')] = $value;
            }
        }

        return $dataSource;
    }
}