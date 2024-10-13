<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\VersionService;
use Illuminate\Http\Request;

class VersionController extends BaseController {
    private $versionService;
    public function __construct() {
        $this->versionService = new VersionService();
    }

    public function getVersionList(Request $request): bool|string {
        return $this->response($this->versionService->getVersionList());
    }
}
