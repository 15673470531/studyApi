<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Repositories\FeedbackRepository;
use Throwable;

class FeedbackService {

    private FeedbackRepository $feedbackRep;

    public function __construct() {
        $this->feedbackRep = new FeedbackRepository();
    }

    public function submit(int $userid, string $content): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            if (empty($userid)) {
                throw new ApiException('您还未登录');
            }
            if (empty($content)) {
                throw new ApiException('反馈内容不能为空');
            }

            if (!$this->feedbackRep->createMessage($userid, $content)) {
                throw new ApiException('数据库繁忙,提交失败');
            }
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
