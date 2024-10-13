<?php

namespace App\Services;

use App\Constants\WxOpenapiConstant;
use App\Exceptions\ApiException;
use App\Repositories\LoginUserRepository;
use App\Services\Tool\RequestService;
use Throwable;

class WxOpenapiService extends BaseService {
    public function getOpenidAndSessionKey(string $code): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            if (empty($code)) {
                throw new ApiException('code为空');
            }
            $url    = 'https://api.weixin.qq.com/sns/jscode2session';
            $params = [
                'appid'      => WxOpenapiConstant::AppID,
                'secret'     => WxOpenapiConstant::AppSecret,
                'js_code'    => $code,
                'grant_type' => 'authorization_code',
            ];
            list($requestOK, $requestMsg, $requestData) = RequestService::get($url, $params);
            if (!$requestOK) {
                throw new ApiException($requestMsg);
            }
            $data = $requestData;
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

    public function getWxAccessToken(string $code): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            if (empty($code)) {
                throw new ApiException('code为空');
            }

            $url    = 'https://api.weixin.qq.com/sns/oauth2/access_token';
            $params = [
                'appid'      => WxOpenapiConstant::AppID,
                'secret'     => WxOpenapiConstant::AppSecret,
                'code'       => $code,
                'grant_type' => 'authorization_code',
            ];
            list($requestOK, $requestMsg, $requestData) = RequestService::get($url, $params);
            if (!$requestOK) {
                throw new ApiException($requestMsg);
            }
            $data = $requestData;
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
