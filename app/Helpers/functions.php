<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('log_d')) {
    function log_d(string $method, string $logs) {
        Log::debug($method, [$logs]);
    }
}

if (!function_exists('log_i')) {
    function log_i(string $method, string $logs) {
        Log::info($method, [$logs]);
    }
}

if (!function_exists('log_e')) {
    function log_e(string $method, string $logs) {
        Log::error($method, [$logs]);
    }
}

if (!function_exists('_j')) {
    function _j($arr): bool|string {
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('varDumpExit')) {
    function varDumpExit(...$data) {
        foreach ($data as $datum) {
            var_dump($datum);
        }
        exit;
    }
}

if (!function_exists('dispatch_without_throw')) {
    function dispatch_without_throw(callable $callable): bool {
        try {
            $r = $callable();
            Log::channel('event')->debug('dispatch_without_throw', [$r]);
            return true;
        } catch (\Throwable $e) {
            Log::channel('event')->error($e->getMessage());
            return false;
        }
    }
}
