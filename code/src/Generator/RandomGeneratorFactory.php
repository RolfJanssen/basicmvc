<?php

namespace App\Generator;

use App\Generator\Exception\GeneratorNotFoundException;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Log\Logger;

class RandomGeneratorFactory
{
    public const CHUCK_NORRIS_GENERATOR = 'chuck_norris';
    public const RANDOM_STRING_GENERATOR = 'random_string';

    public static function build(string $type): RandomGeneratorInterface
    {
        switch($type) {
            case self::CHUCK_NORRIS_GENERATOR;
                return new RandomChuckNorrisFactGenerator(
                    new Logger(null, fopen('/var/www/log/dev.log', 'r+')),
                    new Client()
                );
            case self::RANDOM_STRING_GENERATOR:
                return new RandomStringGenerator();
            default:
                throw new GeneratorNotFoundException(sprintf( 'Generator of type %s not found', $type));
        }
    }
}
