<?php

namespace Test\ReorderFrequency\Cron;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Model\AdminOrder\Create;
use Test\ReorderFrequency\Logger\Logger;
use Magento\Sales\Model\OrderFactory;
use Magento\Backend\Model\Session\Quote;

class Reorder
{
	protected $logger;

	public $_orderCollection;

	public $_orderModel;

	public $_orderFactory;

	protected $_session;


	public function __construct(
		Logger $loggerInterface,
		Create $orderModel,
		CollectionFactory $orderCollection,
		OrderFactory $orderFactory,
		Quote $session
	) {
		$this->logger = $loggerInterface;
		$this->_orderCollection = $orderCollection;
		$this->_orderModel = $orderModel;
		$this->_orderFactory = $orderFactory;
		$this->_session = $session;
	}

	public function execute() 
	{
		$orderColl = $this->_orderCollection->create()
				->addFieldToSelect(array('reorder_frequency','is_reorder_done','created_at'))
				->addFieldToFilter('reorder_frequency', ['neq' => 'NULL'])
				->addFieldToFilter('is_reorder_done',['eq'=>0]); 

		if( $orderColl->getSize() > 0 ){

			$this->_session->getUseOldShippingMethod(true);

			foreach ($orderColl as $_order) {

				$createdAt = $_order->getCreatedAt();
				
				switch ($_order->getReorderFrequency()) {
					case \Test\ReorderFrequency\Model\Config::DAILY_SUBSCRIPTION:
						$createdAt = date('Y-m-d', strtotime('+1 day', strtotime($createdAt)));
						break;
					
					case \Test\ReorderFrequency\Model\Config::WEELY_SUBSCRIPTION:
						$createdAt = date('Y-m-d', strtotime('+7 day', strtotime($createdAt)));
						break;

					case \Test\ReorderFrequency\Model\Config::MONTHLY_SUBSCRIPTION:
						$createdAt = date('Y-m-d', strtotime('+30 day', strtotime($createdAt)));
						break;
				}

				$currDate = $this->getCurrentDate();
				if( $createdAt == $currDate ){
					$this->createOrder( $_order );
				}
			}

			$this->_session->getUseOldShippingMethod(false);

		} else{
			$this->logger->info('No orders available for suscription');
		}
		
	}

	public function createOrder( $order )
	{
		$orig_order = $this->_orderFactory->create()->load($order->getId());
	    $payment = $orig_order->getPayment();
	    $method = $payment->getMethodInstance();
	    $methodCode = $method->getCode();
	   
		try {
	   		$orig_order->setReordered(true);

		   	$reorder = $this->_orderModel->initFromOrder($orig_order);
		   	$reorderQuote = $reorder->getQuote();
		   	$reorderQuote->setInventoryProcessed(false); //decrease item stock equal to qty

		    $reorderQuote->save(); //quote save 

		   	$reorderQuote->getShippingAddress()->setCollectShippingRates(true);
		   	$reorderQuote->setTotalsCollectedFlag(false)->collectTotals();

			$reorderQuote->setPaymentMethod($methodCode); //payment method
			$reorderQuote->getPayment()->importData(['method' => $methodCode]);
			$reorderQuote->collectTotals()->save();

			$newOrder = $reorder->createOrder();
			$newOrder->setReorderFrequency($orig_order->getReorderFrequency())->save();
			$orig_order->setIsReorderDone(1)->save();

			$logData = [];
			$logData['original_order_id'] = $orig_order->getIncrementId();
			$logData['new_order_id'] = $newOrder->getIncrementId();

			$this->logger->info(print_r($logData,true));

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function getCurrentDate()
	{
		return date('Y-m-d');
	}
}