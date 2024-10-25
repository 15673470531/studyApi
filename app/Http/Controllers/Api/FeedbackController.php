<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends BaseController {

    private $feedbackService;

    public function __construct() {
        $this->feedbackService = new FeedbackService();
    }

    public function submit(Request $request): bool|string {
        $content = strval($request->input('content'));
        $userid = intval($request->get('uid'));
        return $this->response($this->feedbackService->submit($userid, $content));
    }
}
