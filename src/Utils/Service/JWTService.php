<?php

declare (strict_types = 1);

namespace Utils\Service;

use Core\Base\BaseService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class JWTService extends BaseService {

    public static function CreateToken(?object $user): string {
        $daySecond = 24 * 60 * 60;

        $itemInfo = [
            "userId" => $user->id,
            "email" => $user->email,
            "userName" => $user->userName,
            "iss" => JWT_ISSUER,
            "aud" => JWT_AUDIENCE,
            'exp' => time() + (JWT_EXPIRE_DAY * $daySecond),
            'iat' => time(),
        ];

        $newToken = JWT::encode($itemInfo, JWT_SECRET_KEY, 'HS256');
        return $newToken;
    }

    public static function DecodeToken(): mixed {
        $jwtHeader = self::getHeader();
        if ($jwtHeader == null) {
            return null;
        }
        $jwtToken = end(explode('Bearer ', $jwtHeader));
        $decodedToken = JWT::decode($jwtToken, new Key(JWT_SECRET_KEY, 'HS256'));
        return $decodedToken;
    }

    public static function GetInfo(?string $attribute = null): mixed {
        $jwtHeader = self::getHeader();
        if ($jwtHeader == null) {
            return null;
        }
        $jwtToken = end(explode('Bearer ', $jwtHeader));
        $decodedToken = JWT::decode($jwtToken, new Key(JWT_SECRET_KEY, 'HS256'));
        return $decodedToken->$attribute;
    }

    private static function getHeader(): ?string {
        $jwtHeader = null;

        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $jwtHeader = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $jwtHeader = trim($requestHeaders['Authorization']);
            }
        }

        return $jwtHeader;
    }

}
