<?php

namespace App\Models\Enum;

class UserEnum
{
    // 状态类别
    public const INVALID = -1; //已删除
    public const NORMAL  = 0; //正常
    public const FREEZE  = 1; //冻结

    public static function getStatusName($status)
    {
        switch ($status) {
            case self::INVALID:
                return '已删除';
            case self::NORMAL:
                return '正常';
            case self::FREEZE:
                return '冻结';
            default:
                return '正常';
        }
    }
}