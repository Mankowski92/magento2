<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Man\ModelDbModule\Model\ResourceModel;

class IpAddress extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('man_modeldbmodule_ipaddress', 'ipaddress_id');
    }
}

