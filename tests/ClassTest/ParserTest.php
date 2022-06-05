<?php

declare(strict_types=1);

namespace Tests\ClassTest;

use PHPUnit\Framework\TestCase;
use App\Parser;

class ParserTest extends TestCase
{
    /**
     * Test data parsing
     * 
     * @return void
     */
    public function testParsingData(): void
    {
        $data = [
            '[silencedetect @ 0x7fa7edd0c160] silence_start: 1.84',
            '[silencedetect @ 0x7fa7edd0c160] silence_end: 4.48 | silence_duration: 2.64',
            '[silencedetect @ 0x7fa7edd0c160] silence_start: 26.928',
            '[silencedetect @ 0x7fa7edd0c160] silence_end: 29.184 | silence_duration: 2.256',
            '[silencedetect @ 0x7fa7edd0c160] silence_start: 29.36',
            '[silencedetect @ 0x7fa7edd0c160] silence_end: 31.744 | silence_duration: 2.384',
        ];
        $expectedRes = [
            'silence_duration' => array_sum([2.64, 2.256, 2.384]),
            'data' => [[0, 1.84],[4.48, 26.928],[29.184, 29.36]],
            'call_duration' => 31.744
        ];

        $res = (new Parser())->formatData($data);
        $this->assertSame($expectedRes, $res);
    }
}