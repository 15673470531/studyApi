<?php

namespace App\Commons;

class Utils {
    public static function arrayGroupByField(array $array, string $groupField, string $valueField = ''): array {
        $groupArr = [];
        foreach ($array as $item) {
            if (isset($valueField) && $valueField) {
                $value = $item[$valueField] ?? '';
            } else {
                $value = $item;
            }
            $groupArr[$item[$groupField]][] = $value;
        }
        return $groupArr;
    }

    public static function getRandomNums($length = 6): string {
        $verifyCode = '';
        $str = '1234567890';
        //定义用于验证的数字和字母;
        $l = strlen($str); //得到字串的长度;
        //循环随机抽取四位前面定义的字母和数字;
        for ($i = 1; $i <= $length; $i++) {
            $num = rand(0, $l - 1);
            //每次随机抽取一位数字;从第一个字到该字串最大长度,
            $verifyCode .= $str[$num];
        }
        return $verifyCode;
    }

    public static function arraySortByField(array $sortArray,string $sortField,string $sortType = 'asc'): array
    {
        $sortType = strtolower($sortType);
        if ('asc' == $sortType){
            $sortOrder = SORT_ASC;
        }elseif ('desc' == $sortType){
            $sortOrder = SORT_DESC;
        }else{
            throw new \InvalidArgumentException('error sort type : '._j($sortType));
        }
        $sortColumn = array_column($sortArray,$sortField);
        array_multisort($sortColumn,$sortOrder,$sortArray);
        return $sortArray;
    }

    public static function arrayUnique(?array $arr): array {
        if (empty($arr)){
            return [];
        }
        return array_merge(array_unique($arr));
    }

}
