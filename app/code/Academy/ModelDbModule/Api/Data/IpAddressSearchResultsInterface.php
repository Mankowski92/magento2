<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Academy\ModelDbModule\Api\Data;

interface IpAddressSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get IpAddress list.
     * @return \Academy\ModelDbModule\Api\Data\IpAddressInterface[]
     */
    public function getItems();

    /**
     * Set current_ip_address list.
     * @param \Academy\ModelDbModule\Api\Data\IpAddressInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

