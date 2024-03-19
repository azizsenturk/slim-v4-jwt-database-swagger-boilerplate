<?php

declare (strict_types = 1);

namespace Core\Config;

class AllowedOrigins {
    public static function getOrigins() {
        $origins = [
            PROJECT_DOMAIN,
            'http://localhost',
        ];

        return $origins;
    }
}