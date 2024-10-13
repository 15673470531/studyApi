<?php

namespace App\Repositories;

use App\Models\TermTaxonomy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TermTaxonomyRepository extends BaseRepository {
    private Builder $termTaxonomyMd;

    public function __construct() {
        $this->termTaxonomyMd = TermTaxonomy::query();
    }

    public function findAllValidCategory(): array {
        return $this->termTaxonomyMd->where('is_delete', 0)->where('taxonomy', 'category')->get()->toArray();
    }
}
