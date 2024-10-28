<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ApiException extends Exception {
    public const        isProduction                     = true;//是否生产环境
    public const        ERROR_SHOW_USER                  = '系统错误';
    public const        ERROR_MSG_STORE_ID_INVALID       = '门店id为空';
    public const        ERROR_CODE_REQUEST_ESTIMATE_FAIL = 1;

    public static function getErrorDesc(Throwable $e): string {
        return self::isProduction ? self::ERROR_SHOW_USER : sprintf('%s %s line：%s', $e->getMessage(), PHP_EOL, $e->getLine());
    }

    public static function getSuccessDesc(string $successMsg = ''): string {
        return $successMsg ?: '操作成功';
    }

    public static function getRealErrorMsg(Throwable $e): string {
        return sprintf('%s-%s-line:%s', '系统抛异常', $e->getMessage(), $e->getLine());
    }
}

