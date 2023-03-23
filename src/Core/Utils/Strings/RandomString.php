<?php

namespace App\Core\Utils\Strings;

use RandomLib\Factory;
use SecurityLib\Strength;

class RandomString
{
    private string $characters;
    private $generator;

    public function __construct($characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_")
    {
        $this->characters = $characters;
        $factory = new Factory();
        $this->generator = $factory->getGenerator(new Strength(Strength::MEDIUM));
    }

    public function generate(int $length = 21): string
    {
        return $this->generator->generateString($length, $this->characters);
    }
}