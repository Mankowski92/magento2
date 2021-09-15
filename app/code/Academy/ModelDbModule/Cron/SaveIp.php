<?php

namespace Academy\ModelDbModule\Cron;

use Academy\ModelDbModule\Api\Data\IpAddressInterface;
use Academy\ModelDbModule\Api\IpAddressRepositoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

class SaveIp
{
    protected $logger;
    private IpAddressRepositoryInterface $ipAddressRepository;
    private IpAddressInterface $ipAddress;
    private \Magento\Store\Model\StoreManagerInterface $storeManager;
    private RemoteAddress $remote;

    public function __construct(
        LoggerInterface $logger,
        IpAddressRepositoryInterface $ipAddressRepository,
        IpAddressInterface $ipAddress,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        RemoteAddress $remote
    ) {
        $this->logger = $logger;
        $this->ipAddressRepository = $ipAddressRepository;
        $this->ipAddress = $ipAddress;
        $this->storeManager = $storeManager;
        $this->remote = $remote;
    }

    public function execute()
    {
        // $this->ipAddress->setCurrentIpAddress($this->remote->getRemoteAddress());

        $ip = file_get_contents('https://ipinfo.io/ip');

        $this->ipAddress->setCurrentIpAddress($ip);
        $this->ipAddressRepository->save($this->ipAddress);

        $this->logger->info('Ip checker cron job');
        $this->logger->info($ip);
    }
}
