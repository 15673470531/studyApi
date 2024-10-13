<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    private $articleService;
    public function __construct() {
        $this->articleService = new ArticleService();
    }

    public function getList(): bool|string {
        $userid = 1;
        $list = $this->articleService->getArticleListByUserid($userid);
        return $this->success($list);
    }
}
