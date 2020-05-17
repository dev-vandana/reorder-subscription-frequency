<?php
namespace Test\ReorderFrequency\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class ReorderFrequencyConfigProvider implements ConfigProviderInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * ReorderFrequencyConfigProvider constructor.
     *
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->config->getConfig();
    }
}