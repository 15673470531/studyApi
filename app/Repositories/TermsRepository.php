<?php

namespace App\Repositories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Builder;

class TermsRepository extends BaseRepository {
    private Builder $termMd;

    public function __construct() {
        $this->termMd = Term::query();
    }

    public function findAllValid(): array {
        return $this->termMd->where('is_delete', 0)->get()->toArray();
    }

    public function findAllValidTermIdNameMap(): array {
        $terms = $this->findAllValid();
        return array_column($terms,'name','term_id');
    }
}
