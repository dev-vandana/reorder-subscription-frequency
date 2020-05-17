<?php
namespace Test\ReorderFrequency\Model;

use Magento\Framework\Stdlib\DateTime\DateTime;

class Validator
{
    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * Validator constructor.
     *
     * @param DateTime $dateTime
     */
    public function __construct(
        DateTime $dateTime
    ) {
        $this->dateTime = $dateTime;
    }

    /**
     * @param string $reorderFrequency
     * @return bool
     */
    public function validate($reorderFrequency)
    {
        return true;
    }
}