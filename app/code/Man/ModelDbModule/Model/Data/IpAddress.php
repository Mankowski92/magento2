<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Man\ModelDbModule\Model\Data;

use Man\ModelDbModule\Api\Data\IpAddressInterface;

class IpAddress extends \Magento\Framework\Api\AbstractExtensibleObject implements IpAddressInterface
{

    /**
     * Get ipaddress_id
     * @return string|null
     */
    public function getIpaddressId()
    {
        return $this->_get(self::IPADDRESS_ID);
    }

    /**
     * Set ipaddress_id
     * @param string $ipaddressId
     * @return \Man\ModelDbModule\Api\Data\IpAddressInterface
     */
    public function setIpaddressId($ipaddressId)
    {
        return $this->setData(self::IPADDRESS_ID, $ipaddressId);
    }

    /**
     * Get current_ip_address
     * @return string|null
     */
    public function getCurrentIpAddress()
    {
        return $this->_get(self::CURRENT_IP_ADDRESS);
    }

    /**
     * Set current_ip_address
     * @param string $currentIpAddress
     * @return \Man\ModelDbModule\Api\Data\IpAddressInterface
     */
    public function setCurrentIpAddress($currentIpAddress)
    {
        return $this->setData(self::CURRENT_IP_ADDRESS, $currentIpAddress);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Man\ModelDbModule\Api\Data\IpAddressExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Man\ModelDbModule\Api\Data\IpAddressExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Man\ModelDbModule\Api\Data\IpAddressExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

