<?php

use App\Service\HashGenerator;
use PHPUnit\Framework\TestCase;

class HashGeneratorTest extends TestCase
{
    const VALID_CHARS = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890_-';

    public function testGenerate()
    {
        $generator = new HashGenerator();

        $hash = $generator->generate(8);

        $this->assertEquals(8, strlen($hash));

        foreach (str_split($hash) as $char) {
            $this->assertNotFalse(strpos(self::VALID_CHARS, $char));
        }
    }
}
