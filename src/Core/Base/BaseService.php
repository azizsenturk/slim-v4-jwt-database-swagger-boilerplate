<?php

declare (strict_types = 1);

namespace Core\Base;

use Buki\Pdox;

abstract class BaseService {
    protected static $pdo;

    public static function setPDO(Pdox $pdo) {
        self::$pdo = $pdo;
    }

}
