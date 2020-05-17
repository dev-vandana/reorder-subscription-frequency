<?php

namespace Test\ReorderFrequency\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetup;
use Magento\Quote\Setup\QuoteSetup;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
	/**
	 * EAV setup factory
	 *
	 * @var EavSetupFactory
	 */
	private $eavSetupFactory;
	private $_salesSetup;
	private $_quoteSetup;

	/**
	 * Init
	 *
	 * @param EavSetupFactory $eavSetupFactory
	 */
	public function __construct(
		EavSetupFactory $eavSetupFactory,
		SalesSetup $salesSetup,
		QuoteSetup $quoteSetup
	){
		$this->eavSetupFactory = $eavSetupFactory;
		$this->_salesSetup = $salesSetup;
		$this->_quoteSetup = $quoteSetup;
	}

	/**
	 * {@inheritdoc}
	 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
	 */
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		/** @var EavSetup $eavSetup */
		$this->_salesSetup->addAttribute('order', 'reorder_frequency', ['type' =>'int']);
		$this->_salesSetup->addAttribute('order', 'is_reorder_done', ['type' =>'int']);

		$this->_quoteSetup->addAttribute('quote', 'reorder_frequency', ['type' =>'int']);

	}
}