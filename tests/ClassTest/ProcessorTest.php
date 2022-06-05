<?php

declare(strict_types=1);

namespace Tests\ClassTest;

use PHPUnit\Framework\TestCase;
use App\Processor;

class ProcessorTest extends TestCase
{
    /**
     * @var Processor
     */
    private $processor;

    /**
     * @var array
     */
    private $data;

    /**
     * Set up environment before every test
     * 
     * @return void
     */
    public function setUp(): void
    {
        $this->processor = new Processor();
        $this->data = [
            [2.32, 3.45], //1.13
            [4.78, 23.34],  //18.56
            [27.124, 59.34] //32.216
        ];
    }

    /**
     * Test finding longest monolog
     * 
     * @return void
     */
    public function testFindingLongestTalk(): void
    {
       $longestTalkDuration = $this->processor->findLongestTalk($this->data);
       $expected = 32.216;
       $this->assertEqualsWithDelta($expected, $longestTalkDuration, 0.0001);
    }

    /**
     * Test calcualte percent talk time
     * 
     * @return void
     */
    public function testPercentageTalk(): void
    {
        $callDuration = 180.00;
        $percentsTalk = $this->processor->findPercentageTalk($this->data, $callDuration);
        $expected = 28.836;
        $this->assertEqualsWithDelta($expected, $percentsTalk, 0.001);
    }

    /**
     * Test finding conversation duration
     * 
     * @return void
     */
    public function testFindingCallDuration(): void
    {
        $userDataLastPoint = 1223.45;
        $customerDataLastPoint = 1225.22;
        $callDuration = $this->processor->getCallDuration($userDataLastPoint, $customerDataLastPoint);
        $expected = 1225.22;
        $this->assertEqualsWithDelta($expected, $callDuration, 0.0001);
    }
}