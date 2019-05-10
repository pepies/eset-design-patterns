<?php

namespace Tests\ESET\Debug;

use ESET\Debug\ErrorHandler;
use ESET\Debug\ErrorLoggerProcessor;
use ESET\Debug\ErrorProcessor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

final class ErrorHandlerTest extends TestCase
{
    protected function tearDown(): void
    {
        ErrorHandler::getInstance()->unregister();
    }

    public function testCaptureError(): void
    {
        /*$logger = new Logger('debug', [
            new StreamHandler('/tmp/test.log'),
        ]);*/

        $handler = ErrorHandler::create();

        $spy = new class($handler) implements ErrorProcessor {
            private $handler;
            public $count = 0;

            public function __construct(ErrorHandler $handler)
            {
                $this->handler = $handler;
            }

            public function process(\Throwable $e): void
            {
                ++$this->count;
            }
        };

        $handler
            //->addProcessor(new ErrorLoggerProcessor($logger))
            ->addProcessor($spy)
            ->register()
        ;

        trigger_error('Warning Error', E_USER_WARNING);
        trigger_error('Warning Error', E_USER_WARNING);

        $this->assertCount(2, $handler->getErrors());
        $this->assertSame(2, $spy->count);
    }

    public function testErrorHandlerIsSingleton(): void
    {
        $handler1 = ErrorHandler::create();
        $handler2 = ErrorHandler::create();

        $this->assertSame($handler1, $handler2);
    }
}
