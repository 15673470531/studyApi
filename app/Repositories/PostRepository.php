<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostRepository extends BaseRepository {
    private Builder $model;
    public function __construct() {
        $this->model = Post::query();
    }

    public function getArticleById(int $id, array $fields = []): array {
        return $this->model->where('id', $id)->where('is_delete', 0)->select($fields)->first()->toArray();
    }

    public function getArticleList(array $fields = []): array {
        return $this->model->select($fields)->where('is_delete', 0)->get()->toArray();
    }

    public function getArticleListByTermId(int $termId) {

    }

    public function getPostListByIds(array $postIds, array $fields = []): array {
        return $this->model->whereIn('id', $postIds)->select($fields)->get()->toArray();
    }
}
