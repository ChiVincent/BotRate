<?php

namespace Chivincent\BotRate;

use GuzzleHttp\Client;
use League\Csv\Reader;
use Psr\Http\Message\ResponseInterface;

class BotRate
{
    const URL = 'http://rate.bot.com.tw/xrt/flcsv/0/day';
    protected $data;
    protected $timestamp;

    public function __construct()
    {
    }

    public function fetch(): BotRate
    {
        $client = new Client();
        $response = $client->get(BotRate::URL, [
            'headers' => [
                'Accept-Language' => 'en',
            ]
        ]);

        $this->data = $response->getBody()->getContents();
        $this->timestamp = $this->updateTime($response);


        return $this;
    }

    public function toJson($currency = null): string
    {
        $reader = Reader::createFromString($this->data);
        $keys = [];
        $rate = [
            'timestamp' => $this->timestamp,
        ];

        foreach ($reader as $index => $row) {
            if ($index === 0) {
                $keys = $row;
                continue;
            }

            $tmp = [];
            $tmp[$keys[0]] = $row[0];

            for ($i = 2 ; $i <= 10 ; $i++) {
                $tmp[$row[1]][$keys[$i]] = $row[$i];
            }
            for ($i = 12 ; $i <= 20 ; $i++) {
                $tmp[$row[11]][$keys[$i]] = $row[$i];
            }

            array_push($rate, $tmp);
        }

        if (json_encode($rate) != false)
            return json_encode($rate);
        else
            return json_encode([]);
    }

    protected function updateTime(ResponseInterface $response): int
    {
        $contentDisposition = $response->getHeader('Content-Disposition')[0];
        $match = [];

        preg_match('/ExchangeRate@(.*).csv/', $contentDisposition, $match);
        if (isset($match[1]))
            return strtotime($match[1]);

        return -1;
    }
}