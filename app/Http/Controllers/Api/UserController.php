<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController {
    private $userService;
    public function __construct() {
        $this->userService = new UserService();
    }

    public function getUserToken(Request $request): bool|string {
        $code = $request->input('code');
        return $this->response($this->userService->getUserToken(strval($code)));
    }
}
