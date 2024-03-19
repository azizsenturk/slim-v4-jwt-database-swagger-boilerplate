<?php

declare (strict_types = 1);

namespace Utils\Libs;

use Utils\Exception\BadRequest;

class Validator {
    public static function Email(string $item): bool {
        $isMatched = preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $item);
        return self::checkResult($isMatched, 'Email is not valid.');
    }

    public static function Phone(string $item): bool {
        $isMatched = preg_match('/^(\+90|0)[0-9]{10}$/', $item);
        return self::checkResult($isMatched, 'Phone is not valid.');
    }

    public static function Required(mixed $item, ?string $decription = null): bool {
        if (empty($item)) {
            throw new BadRequest($decription ?? 'This field is required.');
        }
        return true;
    }

    public static function IsTrue(bool $condition, ?string $decription = null): bool {
        if ($condition) {
            throw new BadRequest($decription ?? 'Condition is not true.');
        }
        return true;
    }

    private static function checkResult($isMatched, string $message): bool {
        if ($isMatched !== 1) {
            throw new BadRequest($message);
        }
        return true;
    }
}