<?php

namespace App\Services;

use GuzzleHttp\Client;

class BrightDataService
{
    public static function client(): Client
    {
        $user = config('brightdata.user');
        $pass = config('brightdata.pass');
        $host = config('brightdata.host');
        $port = config('brightdata.port');

        $proxy = "http://{$user}:{$pass}@{$host}:{$port}";

        return new Client([
            'timeout' => 30,
            'connect_timeout' => 10,
            'proxy' => [
                'http'  => $proxy,
                'https' => $proxy,
            ],
            'headers' => [
                'User-Agent' => 'Laravel-BrightData',
            ],
        ]);
    }

    // Test method (same as Bright Data terminal test)
    public static function test()
    {
        $client = self::client();

        $res = $client->get(
            'https://geo.brdtest.com/welcome.txt?product=resi&method=native'
        );

        return (string) $res->getBody();
    }
}
