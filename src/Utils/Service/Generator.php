<?php

declare (strict_types = 1);

namespace Utils\Service;

use Core\Base\BaseService;

final class Generator extends BaseService {

    public static function UniqId(string $tableName, ?string $columnName = null): string {

        $newUniqId = substr(str_replace('.', '', ltrim(uniqid('', true), '0')), 0, 11);
        $isUniq = self::$pdo->table($tableName)->where($columnName ?? 'id', $newUniqId)->get();

        if (!$isUniq) {
            return $newUniqId;
        } else {
            return self::uniqId($tableName, $columnName);
        }

    }

    public static function Slug($string = null): ?string {
        if ($string === null) {
            return null;
        }

        // Change Turkish characters to English characters
        $tr = array('ş', 'Ş', 'ı', 'I', 'İ', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'Ç', 'ç');
        $eng = array('s', 's', 'i', 'i', 'i', 'g', 'g', 'u', 'u', 'o', 'o', 'c', 'c');
        $string = str_replace($tr, $eng, $string);

        $string = preg_replace('/[^a-zA-Z0-9]/', ' ', $string); // Change special characters to space
        $string = preg_replace('/\s+/', ' ', $string); // Change multiple spaces to single space
        $string = str_replace(' ', '-', $string); // Change space to dash
        $string = strtolower($string); // Change to lowercase
        $string = preg_replace('/[^a-z0-9-]/', '', $string); // Remove special characters
        $string = preg_replace('/-+/', '-', $string); // Remove multiple dashes
        $string = trim($string, '-'); // Remove dashes from start and end

        return $string;
    }

    public static function CurrentDate(): string {
        return date('Y-m-d H:i:s');
    }

}
