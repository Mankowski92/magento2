<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Academy\ModelDbModule\Model;

use Academy\ModelDbModule\Api\Data\IpAddressInterface;
use Academy\ModelDbModule\Api\Data\IpAddressInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class IpAddress extends \Magento\Framework\Model\AbstractModel
{

    protected $ipaddressDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'academy_modeldbmodule_ipaddress';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param IpAddressInterfaceFactory $ipaddressDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Academy\ModelDbModule\Model\ResourceModel\IpAddress $resource
     * @param \Academy\ModelDbModule\Model\ResourceModel\IpAddress\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        IpAddressInterfaceFactory $ipaddressDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Academy\ModelDbModule\Model\ResourceModel\IpAddress $resource,
        \Academy\ModelDbModule\Model\ResourceModel\IpAddress\Collection $resourceCollection,
        array $data = []
    ) {
        $this->ipaddressDataFactory = $ipaddressDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve ipaddress model with ipaddress data
     * @return IpAddressInterface
     */
    public function getDataModel()
    {
        $ipaddressData = $this->getData();
        
        $ipaddressDataObject = $this->ipaddressDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $ipaddressDataObject,
            $ipaddressData,
            IpAddressInterface::class
        );
        
        return $ipaddressDataObject;
    }
}

