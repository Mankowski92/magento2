<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Academy\ModelDbModule\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface IpAddressRepositoryInterface
{

    /**
     * Save IpAddress
     * @param \Academy\ModelDbModule\Api\Data\IpAddressInterface $ipAddress
     * @return \Academy\ModelDbModule\Api\Data\IpAddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Academy\ModelDbModule\Api\Data\IpAddressInterface $ipAddress
    );

    /**
     * Retrieve IpAddress
     * @param string $ipaddressId
     * @return \Academy\ModelDbModule\Api\Data\IpAddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($ipaddressId);

    /**
     * Retrieve IpAddress matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Academy\ModelDbModule\Api\Data\IpAddressSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete IpAddress
     * @param \Academy\ModelDbModule\Api\Data\IpAddressInterface $ipAddress
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Academy\ModelDbModule\Api\Data\IpAddressInterface $ipAddress
    );

    /**
     * Delete IpAddress by ID
     * @param string $ipaddressId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($ipaddressId);
}

