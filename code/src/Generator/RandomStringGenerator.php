<?php

namespace App\Generator;

class RandomStringGenerator implements RandomGeneratorInterface
{
    public const DEFAULT_LENGTH = 10;

    public function generate(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < self::DEFAULT_LENGTH; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
