<?php

namespace App\Http\Controllers;

class BaseController extends Controller {
    public function success(array $data = [], string $msg = '操作成功'): bool|string {
        $ok = true;
        $return = compact('ok', 'msg', 'data');
        return json_encode($return, JSON_UNESCAPED_UNICODE);
    }

    public function fail(string $msg = '操作失败', array $data = []): bool|string {
        $ok = false;
        return json_encode(compact('ok', 'msg', 'data'), JSON_UNESCAPED_UNICODE);
    }

    public function response(array $returnData): bool|string {
        list($ok, $msg, $data) = $returnData;
        if ($ok) {
            return $this->success($data, $msg);
        } else {
            return $this->fail($msg, $data);
        }
    }
}
