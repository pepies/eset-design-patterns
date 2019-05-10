<?php

namespace ESET\Debug;

final class ErrorHandler
{
    private static $instance;

    private $errorLevel;
    private $previousErrorLevel;
    private $registered = false;

    private $errors = [];
    private $exceptions = [];
    private $processors;

    public static function create(int $errorLevel = E_ALL): self
    {
        if (self::$instance) {
            return self::$instance;
        }

        self::$instance = new self($errorLevel);

        return self::$instance;
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            throw new \LogicException('Instance has not been created yet. Use ::create() method first.');
        }

        return self::$instance;
    }

    private function __construct(int $errorLevel)
    {
        $this->errorLevel = $errorLevel;
        $this->processors = new \SplObjectStorage();
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \BadMethodCallException('Object deserialization is not allowed.');
    }

    public function addProcessor(ErrorProcessor $processor)
    {
        $this->processors->attach($processor);

        return $this;
    }

    public function handleError(int $number, string $error, string $file, int $line): void
    {
        $this->errors[] = [
            'number' => $number,
            'error' => $error,
            'file' => $file,
            'line' => $line,
            'ts' => time(),
        ];

        $this->notifyProcessors(new \ErrorException($error, 0, $number, $file, $line));
    }

    public function handleException(\Throwable $e): void
    {
        $this->exceptions[] = [
            'exception' => $e,
            'ts' => time(),
        ];

        $this->notifyProcessors($e);
    }

    private function notifyProcessors(\Throwable $error): void
    {
        foreach ($this->processors as $processor) {
            try {
                $processor->process($error);
            } catch (\Throwable $e) {
                // let's ignore and continue...
                throw $e;
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    public function register(): self
    {
        if (!$this->registered) {
            $this->previousErrorLevel = error_reporting($this->errorLevel);
            set_error_handler([$this, 'handleError'], $this->errorLevel);
            set_exception_handler([$this, 'handleException']);
            $this->registered = true;
        }

        return $this;
    }

    public function unregister(): self
    {
        if ($this->registered) {
            error_reporting($this->previousErrorLevel);
            restore_error_handler();
            restore_exception_handler();
            $this->registered = false;
            $this->previousErrorLevel = null;
        }

        return $this;
    }
}
