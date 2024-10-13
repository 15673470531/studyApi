<?php

namespace App\Repositories;

use App\Models\TermRelationship;

class TermRelationshipRepository extends BaseRepository {
    private $termRelationshipMd;
    public function __construct() {
        $this->termRelationshipMd = TermRelationship::query();
    }

    public function getPostIdsByTermId(int $termId): array {
        return $this->termRelationshipMd->where('term_taxonomy_id', $termId)->get()->toArray();
    }

    public function getTermIdsByPostId(int $articleId): array {
        return $this->termRelationshipMd->where('object_id', $articleId)->get()->toArray();
    }
}
