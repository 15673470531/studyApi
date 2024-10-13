<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\ArticleService;
use App\Services\TermService;

class TermController extends BaseController {
    private TermService $termService;
    public function __construct() {
        $this->termService = new TermService();
    }

    public function getTermList(): bool|string {
        return $this->response($this->termService->getTermList());
    }
}
