<?php

namespace App\Service;

class HashGenerator
{
    private const CHARS = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890_-';

    public function generate(int $length): string
    {
        $hash = '';

        while ($length > 0) {
            $hash .= self::CHARS[random_int(0, 63)];
            $length--;
        }

        return $hash;
    }
}