<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Man\ModelDbModule\Model\ResourceModel\IpAddress;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'ipaddress_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Man\ModelDbModule\Model\IpAddress::class,
            \Man\ModelDbModule\Model\ResourceModel\IpAddress::class
        );
    }
}

