<?php

declare (strict_types = 1);

namespace Utils\Libs;

use Utils\Service\Generator;

class Converter {
    public static function ToObject($item): object {
        return json_decode(json_encode($item), false);
    }

    public static function ToArray(object $item): array {
        return json_decode(json_encode($item), true);
    }

    public static function ToCreateArray(object $item): array {
        $item->create_time = Generator::CurrentDate();
        $item->update_time = Generator::CurrentDate();
        $data = json_decode(json_encode($item), true);
        return $data;
    }

    public static function ToUpdateArray(object $item): array {
        $item->update_time = Generator::CurrentDate();
        $data = json_decode(json_encode($item), true);
        return $data;
    }

}