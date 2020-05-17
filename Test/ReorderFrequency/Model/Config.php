<?php
namespace Test\ReorderFrequency\Model;

class Config
{
    const DAILY_SUBSCRIPTION            = 1;
    const WEELY_SUBSCRIPTION            = 2;
    const MONTHLY_SUBSCRIPTION          = 3;



    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $config = [
            'shipping' => [
                'reorder_frequency' => [
                    'customOptionValue' => $this->getCustomOptionValue()
                ]
            ]
        ];

        return $config;
    }

    public function getCustomOptionValue()
    {
        return [
            self::DAILY_SUBSCRIPTION => 'Daily',
            self::WEELY_SUBSCRIPTION => 'Weekly',
            self::MONTHLY_SUBSCRIPTION => 'Monthly'
        ];
    }
}