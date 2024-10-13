<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Repositories\VersionRepository;
use Throwable;

class VersionService extends BaseService {

    private $versionRep;

    public function __construct() {
        $this->versionRep = new VersionRepository();
    }

    public function getVersionList(): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            $list = $this->versionRep->getList();

            $newList = [];
            foreach ($list as $item) {
                $newItem   = [
                    'title' => $item['content'],
                    'desc'  => $item['created'],
                ];
                $newList[] = $newItem;
            }
            $data['list'] = $newList;
        } catch (ApiException $e) {
            $ok  = false;
            $msg = $e->getMessage();
        } catch (Throwable $e) {
            $ok       = false;
            $msg      = ApiException::getErrorDesc($e);
            $errorMsg = ApiException::getRealErrorMsg($e);
        }
        log_i(__METHOD__, sprintf('params:%s, ok:%s, msg:%s, data:%s, errorMsg:%s', _j(func_get_args()), $ok, $msg, _j($data), $errorMsg ?? ''));
        return [$ok, $msg, $data];
    }
}
