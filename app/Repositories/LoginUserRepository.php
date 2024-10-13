<?php

namespace App\Repositories;

use App\Models\LoginUser;

class LoginUserRepository extends BaseRepository {
    private $loginUserMd;

    public function __construct() {
        $this->loginUserMd = LoginUser::query();
    }

    public function createOrUpdateUser(string $openid, string $avatarUrl = '', string $nickname = ''): bool {
        $insertRes = false;
        if (empty($oldUser = $this->loginUserMd->where('openid', $openid)->first())) {
            $insertRes = $this->loginUserMd->insert([
                'openid'     => $openid,
                'avatar_url' => $avatarUrl,
                'nickname'   => $nickname,
            ]);
        }
        return $oldUser || $insertRes;
    }

    public function findUserByOpenid(string $openid): array {
        return $this->loginUserMd->where('openid', $openid)->first()->toArray();
    }
}
