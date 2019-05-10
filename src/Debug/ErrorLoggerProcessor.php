<?php

namespace ESET\Debug;

use Psr\Log\LoggerInterface;

class ErrorLoggerProcessor implements ErrorProcessor
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(\Throwable $e): void
    {
        $this->logger->error($e->getMessage(), [
            'exception' => $e,
        ]);
    }
}
