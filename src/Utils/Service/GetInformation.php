<?php

declare (strict_types = 1);

namespace Utils\Service;

use Core\Base\BaseService;

final class GetInformation extends BaseService {

    public static function SingleItem(string $tableName, $id, ?string $getAttribute = null, ?string $columnName = null): mixed {

        $value = self::$pdo
            ->table($tableName)
            ->select($getAttribute ?? '*')
            ->where($columnName ?? 'id', $id)
            ->get();

        return $value->$getAttribute;

    }

}