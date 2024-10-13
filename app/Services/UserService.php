<?php

namespace App\Services;

use App\Constants\WxOpenapiConstant;
use App\Exceptions\ApiException;
use App\Models\LoginUser;
use App\Repositories\LoginUserRepository;
use App\Services\Tool\RequestService;
use Throwable;

class UserService extends BaseService {

    private $loginUserRep;
    public function __construct() {
        $this->loginUserRep = new LoginUserRepository();
    }

    public function getUserIdByToken(string $tokenString){
        $userid = 0;
        if ($tokenString){
            $tokenString = base64_decode($tokenString);
            list($sessionKey, $openid, $sign) = explode('.', $tokenString);
            $user = $this->loginUserRep->findUserByOpenid($openid);
            $userid = $user['id'];
        }
        return $userid;
    }

    function getUserToken(string $code): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            $wxOpenapiService = new WxOpenapiService();
            //获取accessToken
//            list($getTokenOk, $getTokenMsg, $getTokenData) = $wxOpenapiService->getWxAccessToken($code);
//            varDumpExit($getTokenOk, $getTokenMsg, $getTokenData);

            list($requestOk, $requestMsg, $requestData) = $wxOpenapiService->getOpenidAndSessionKey($code);
            if (!$requestOk) {
                throw new ApiException($requestMsg);
            }
            $session_key = $requestData['session_key'];
            $openid      = $requestData['openid'];

            $sign  = 'study_api';
            $key   = sprintf('%s.%s.%s', md5($session_key), $openid, $sign);
            $token = base64_encode($key);

            $loginUserRep = new LoginUserRepository();
            if (!$loginUserRep->createOrUpdateUser($openid)){
                throw new ApiException('创建或者更新用户失败');
            }
            $data['token'] = $token;
        } catch (ApiException $e) {
            $ok  = false;
            $msg = $e->getMessage();
        } catch (Throwable $e) {
            $ok       = false;
            $msg      = ApiException::getErrorDesc($e);
            $errorMsg = ApiException::getRealErrorMsg($e);
            varDumpExit($errorMsg);
        }
        log_i(__METHOD__, sprintf('params:%s, ok:%s, msg:%s, data:%s, errorMsg:%s', _j(func_get_args()), $ok, $msg, _j($data), $errorMsg ?? ''));
        return [$ok, $msg, $data];
    }
}
