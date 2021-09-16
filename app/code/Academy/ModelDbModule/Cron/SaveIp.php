<?php

namespace Academy\ModelDbModule\Cron;

use Academy\ModelDbModule\Api\Data\IpAddressInterface;
use Academy\ModelDbModule\Api\IpAddressRepositoryInterface;
use Psr\Log\LoggerInterface;
use Academy\ModelDbModule\Model\IpAddressFactory;

class SaveIp
{
    protected $logger;
    private IpAddressRepositoryInterface $ipAddressRepository;
    private IpAddressInterface $ipAddress;
    protected $ipAddressFactory;

    public function __construct(
        LoggerInterface $logger,
        IpAddressRepositoryInterface $ipAddressRepository,
        IpAddressInterface $ipAddress,
        IpAddressFactory $ipAddressFactory
    ) {
        $this->logger = $logger;
        $this->ipAddressRepository = $ipAddressRepository;
        $this->ipAddress = $ipAddress;
        $this->ipAddressFactory = $ipAddressFactory;
    }

    public function execute()
    {
        $ip = file_get_contents('https://ipinfo.io/ip');

        // below variales left for tests purposes

        // $fakeIp = long2ip(rand(0, 4294967295));
        // $randomNumber = (mt_rand(1, 10));

        $this->ipAddress->setCurrentIpAddress($ip);

        $ipModel = $this->ipAddressFactory->create();
        $ipModel->load($ip, 'current_ip_address');

        if ($ipModel->getCurrentIpAddress()) {
            $this->logger->info('IP EXIST: NO SAVE');
        } else {
            $this->logger->info('NEW IP: SAVE');
            $this->ipAddressRepository->save($this->ipAddress);
        }
    }
}
