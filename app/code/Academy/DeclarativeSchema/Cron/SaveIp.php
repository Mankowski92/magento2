<?php
namespace Academy\DeclarativeSchema\Cron;

use Psr\Log\LoggerInterface;

class SaveIp {
    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function execute() {
        $this->logger->info('Declarative schema cron works');
    }
}
