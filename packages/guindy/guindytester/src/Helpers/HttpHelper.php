<?php

namespace Guindy\GuindyTester\Helpers;

use Illuminate\Support\Facades\Http;

class HttpHelper
{
    public static function post(string $url, array $data)
    {
        return Http::post(url($url), $data);
    }

    public static function put(string $url, array $data)
    {
        return Http::put(url($url), $data);
    }

    public static function delete(string $url)
    {
        return Http::delete(url($url));
    }
}
