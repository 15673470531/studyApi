<?php

namespace App\Repositories;

use App\Models\Version;

class VersionRepository extends BaseRepository {
    private $versionMd;
    public function __construct() {
        $this->versionMd = Version::query();
    }

    public function getList(): array {
        return $this->versionMd->orderBy('id','desc')->get()->toArray();
    }
}
