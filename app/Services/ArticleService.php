<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\TermRelationshipRepository;
use App\Repositories\TermsRepository;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class ArticleService extends BaseService {
    private $termRep;
    private PostRepository $postRep;
    private TermRelationshipRepository $termRelationshipRep;

    const BASE_FIELDS = ['ID', 'post_title', 'post_content', 'post_date', 'read_count'];

    public function __construct() {
        $this->postRep             = new PostRepository();
        $this->termRelationshipRep = new TermRelationshipRepository();
        $this->termRep             = new TermsRepository();
    }

    public function getArticleListByUserid(int $userid): array {
        $fields = self::BASE_FIELDS;
        return $this->postRep->getArticleList($fields);
    }

    public function getArticleById(int $articleId): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            $fields  = self::BASE_FIELDS;
            $article = $this->postRep->getArticleById($articleId, $fields);

            $termRelations = $this->termRelationshipRep->getTermIdsByPostId($articleId);
            $termIds       = array_column($termRelations, 'term_taxonomy_id');

            $termIdNameMap = $this->termRep->findAllValidTermIdNameMap();

            $labels = [];
            foreach ($termIds as $termId) {
                $label = $termIdNameMap[$termId] ?? [];
                if (empty($label)) {
                    continue;
                }
                $labels[] = $label;
            }
            $article['labels'] = $labels;
            $data['post']      = $article;
        } catch (ApiException $e) {
            $ok  = false;
            $msg = $e->getMessage();
        } catch (Throwable $e) {
            $ok       = false;
            $msg      = ApiException::getErrorDesc($e);
            $errorMsg = ApiException::getRealErrorMsg($e);
            var_dump($errorMsg);
            exit;
        }
//        log_i(__METHOD__, sprintf('params:%s, ok:%s, msg:%s, data:%s, errorMsg:%s', _j(func_get_args()), $ok, $msg, _j($data), $errorMsg ?? ''));
        return [$ok, $msg, $data];

    }

    public function getArticleListByTermId(int $termId): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            $postList      = [];
            $postRelations = $this->termRelationshipRep->getPostIdsByTermId($termId);
            $postIds       = array_column($postRelations, 'object_id');
            if ($postIds) {
                $fields   = [
                    'ID',
                    'post_title',
                    'read_count'
                ];
                $postList = $this->postRep->getPostListByIds($postIds, $fields);
            }
            $data['list'] = $postList;
        } catch (ApiException $e) {
            $ok  = false;
            $msg = $e->getMessage();
        } catch (Throwable $e) {
            $ok       = false;
            $msg      = ApiException::getErrorDesc($e);
            $errorMsg = ApiException::getRealErrorMsg($e);
        }
//        log_i(__METHOD__, sprintf('params:%s, ok:%s, msg:%s, data:%s, errorMsg:%s', _j(func_get_args()), $ok, $msg, _j($data), $errorMsg ?? ''));
        return [$ok, $msg, $data];
    }
}
