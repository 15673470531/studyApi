<?php

namespace App\Services\Tool;

use App\Exceptions\ApiException;
use GuzzleHttp\Client;
use Throwable;

class RequestService {
    public static function get(string $url, array $params = []): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            $getParams = http_build_query($params);
            $url       = sprintf('%s?%s', $url, $getParams);
            $client    = new Client();
            $response  = $client->request('GET', $url, [

            ]);

            if ($response->getStatusCode() !== 200) {
                throw new ApiException('接口调用失败');
            }
            $body = json_decode($response->getBody(), true);
            if (isset($body['errcode']) && $body['errcode'] !== 0) {
                throw new ApiException('接口调用报错，错误原因: ' . $body['errmsg']);
            }

            $data = $body;
        } catch (ApiException $e) {
            $ok  = false;
            $msg = $e->getMessage();
        } catch (Throwable $e) {
            $ok       = false;
            $msg      = ApiException::getErrorDesc($e);
            $errorMsg = ApiException::getRealErrorMsg($e);
        }
        log_i(__METHOD__, sprintf('params:%s, ok:%s, msg:%s, data:%s, errorMsg:%s', _j(func_get_args()), $ok, $msg, _j($data), $errorMsg ?? ''));
        return [$ok, $msg, $data];

    }
}
