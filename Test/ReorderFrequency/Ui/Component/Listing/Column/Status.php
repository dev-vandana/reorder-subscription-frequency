<?php

namespace Test\ReorderFrequency\Ui\Component\Listing\Column;

use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Sales\Model\OrderFactory;

class Status extends Column
{
    protected $_orderRepository;
    
    public function __construct(
        ContextInterface $context, 
        UiComponentFactory $uiComponentFactory, 
        OrderFactory $orderRepository,
        array $components = [], 
        array $data = []
    ){
        $this->_orderRepository = $orderRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                $order  = $this->_orderRepository->create()->load($item["entity_id"]);
                
                $value = '';
                if( !empty($order->getData('reorder_frequency')) ){
                    if( $order->getData('is_reorder_done') ){
                        $value = "Done";
                    }else{
                        $value = 'Pending';
                    }                    
                }else{
                    $value = '-';
                }
               
                $item[$this->getData('name')] = $value;
            }
        }

        return $dataSource;
    }
}