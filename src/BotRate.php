<?php

namespace Chivincent\BotRate;

use GuzzleHttp\Client;
use League\Csv\Reader;

class BotRate
{
    const URL = 'http://rate.bot.com.tw/xrt/flcsv/0/day';
    protected $data;

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

        return $this;
    }

    public function toJson($currency = null): string
    {
        $reader = Reader::createFromString($this->data);
        $rate = [];

        foreach ($reader as $index => $row) {
            if ($index === 0) continue;

            $tmp = [];
            $tmp['幣別'] = $row[0];
            $tmp['本行買入']['現金'] = $row[2];
            $tmp['本行買入']['即期'] = $row[3];
            $tmp['本行買入']['遠期10天'] = $row[4];
            $tmp['本行買入']['遠期30天'] = $row[5];
            $tmp['本行買入']['遠期60天'] = $row[6];
            $tmp['本行買入']['遠期90天'] = $row[7];
            $tmp['本行買入']['遠期120天'] = $row[8];
            $tmp['本行買入']['遠期150天'] = $row[9];
            $tmp['本行買入']['遠期180天'] = $row[10];
            $tmp['本行賣出']['現金'] = $row[12];
            $tmp['本行賣出']['即期'] = $row[13];
            $tmp['本行賣出']['遠期10天'] = $row[14];
            $tmp['本行賣出']['遠期30天'] = $row[15];
            $tmp['本行賣出']['遠期60天'] = $row[16];
            $tmp['本行賣出']['遠期90天'] = $row[17];
            $tmp['本行賣出']['遠期120天'] = $row[18];
            $tmp['本行賣出']['遠期150天'] = $row[19];
            $tmp['本行賣出']['遠期180天'] = $row[20];

            array_push($rate, $tmp);
        }

        return json_encode($rate);
    }
}