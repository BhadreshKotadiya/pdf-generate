<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

if (!function_exists('logError')) {
    function logError($th, $abort = null)
    {
        Log::error($th->getMessage(), ['path' => dirname(__FILE__)]);
    }
}
