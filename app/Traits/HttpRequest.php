<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait HttpRequest
{

    /**
     * @param $url
     * @param $data
     * @return \Illuminate\Http\Client\Response|void
     */

    public function _get($url, $data = null)
    {
        try {
            return Http::get($url);
        }
        catch (\Exception $exception) {

            Log::info($exception->getMessage());

        }
    }

    /**
     * @param $url
     * @param $data
     * @return \Illuminate\Http\Client\Response|void
     */

    public function _post($url, $data = [])
    {
        try {
            return Http::post($url, $data);
        }
        catch (\Exception $exception) {

            Log::info($exception->getMessage());

        }
    }


}
