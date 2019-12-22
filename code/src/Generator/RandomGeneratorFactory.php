<?php

namespace App\Generator;

use App\Model\Exception\GeneratorNotFoundException;
use Symfony\Component\HttpKernel\Log\Logger;

class RandomGeneratorFactory
{
    public const CHUCK_NORRIS_GENERATOR = 'chuck_norris';
    public const RANDOM_STRING_GENERATOR = 'random_string';

    public static function build(string $type): RandomGeneratorInterface
    {
        switch($type) {
            case self::CHUCK_NORRIS_GENERATOR;
                return new RandomChuckNorrisFactGenerator(new Logger(null, fopen('/var/www/log/dev.log', 'r+')));
                break;
            case self::RANDOM_STRING_GENERATOR:
                return new RandomStringGenerator();
                break;
            default:
                throw new GeneratorNotFoundException($type);
        }
    }
}
