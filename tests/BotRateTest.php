<?php

use PHPUnit\Framework\TestCase;
use Chivincent\BotRate\BotRate;

class BotRateTest extends TestCase
{
    public function testFetch()
    {
        $botRate = new BotRate();

        $this->assertTrue($botRate->fetch() instanceof BotRate);
    }

    public function testToJson()
    {
        $botRate = new BotRate();
        $json = $botRate->fetch()->toJson();

        $this->assertJson($json);
        $this->assertTrue(json_decode($json)->timestamp != -1);
    }
}