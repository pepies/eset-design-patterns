<?php

namespace ESET\Debug;

interface ErrorProcessor
{
    public function process(\Throwable $e): void;
}
