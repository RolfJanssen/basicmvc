<?php

namespace App\Generator\Exception;

use Exception;

class GeneratorNotFoundException extends Exception
{
    protected $message = 'Generator of type %s not found';

    public function __construct(string $type)
    {
        parent::__construct(sprintf($this->message, $type));
    }
}
