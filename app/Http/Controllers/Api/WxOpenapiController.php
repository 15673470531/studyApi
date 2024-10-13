<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\WxOpenapiService;

class WxOpenapiController extends BaseController {

    private $wxOpenapiService;
    public function __construct() {
        $this->wxOpenapiService = new WxOpenapiService();
    }

    public function validateAuthCode(): bool|string {
        $code = strval($_GET['code']);
        return $this->response($this->wxOpenapiService->validateAuthCode($code));
    }
}
