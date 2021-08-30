<?php

namespace Academy\EventAndObserver\Logger\Handler;

use Magento\Framework\Logger\Handler\Base as BaseHandler;
use Monolog\Logger as MonologLogger;

class ErrorHandler extends BaseHandler
{
    protected $loggerType = MonologLogger::ERROR;

    protected $fileName = '/var/log/custom.log';
}
