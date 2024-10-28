<?php

namespace App\Services;

use App\Commons\Utils;
use App\Exceptions\ApiException;
use App\Models\TermTaxonomy;
use App\Repositories\TermsRepository;
use App\Repositories\TermTaxonomyRepository;
use Illuminate\Support\Facades\Log;
use Throwable;

class TermService extends BaseService {

    private TermsRepository $termRep;
    private $termTaxonomyRep;

    public function __construct() {
        $this->termRep         = new TermsRepository();
        $this->termTaxonomyRep = new TermTaxonomyRepository();
    }

    public function getTermList(): array {
        $ok   = true;
        $msg  = ApiException::getSuccessDesc();
        $data = [];
        try {
            $termList      = $this->termRep->findAllValid();
            $termIdNameMap = array_column($termList, 'name', 'term_id');
            $termIdMap     = array_column($termList, null, 'term_id');

            $termTaxonomyList = $this->termTaxonomyRep->findAllValidCategory();
            $childGroupList   = Utils::arrayGroupByField($termTaxonomyList, 'parent');

            $parentTermList = array_filter($termTaxonomyList, function ($item) {
                return $item['parent'] == 0;
            });

            $lists = [];
            $parentTermIds = array_column($parentTermList, 'term_id');
            foreach ($parentTermIds as $parentTermId) {
                $list['title'] = $termIdNameMap[$parentTermId] ?? [];
                $childItems    = $childGroupList[$parentTermId] ?? [];
                $items         = [];
                foreach ($childItems as $childItem) {
                    $item = $termIdMap[$childItem['term_id']];

                    //todo 增加图片地址和题目数量
                    $item['image'] = '/static/img/html.jpeg';
                    $item['totalCount'] = 2;

                    $items[] = $item;
                }
                $list['items'] = $items;
                $lists[]       = $list;
            }

            $data['list'] = $lists;
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
