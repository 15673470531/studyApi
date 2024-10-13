<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends BaseController
{
    private ArticleService $articleService;
    public function __construct() {
        $this->articleService = new ArticleService();
    }

    public function getArticle(int $articleId = 0): bool|string {
        return $this->response($this->articleService->getArticleById($articleId));
    }

    public function getArticleList(int $userid): bool|string {
        $list = $this->articleService->getArticleListByUserid($userid);
        return $this->success($list);
    }

    public function getArticleListByTermId(int $termId): bool|string {
        return $this->response($this->articleService->getArticleListByTermId($termId));
    }
}
