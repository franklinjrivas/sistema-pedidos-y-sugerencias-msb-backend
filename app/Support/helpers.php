<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('log_info')) {
    function log_info($message)
    {
        Log::info($message);
    }
}
