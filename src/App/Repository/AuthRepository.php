<?php

declare (strict_types = 1);

namespace App\Repository;

use App\Model\Auth\AuthUserModel;
use Psr\Container\ContainerInterface;
use Utils\Libs\Converter;
use Utils\Libs\Validator;
use Utils\Service\Generator;
use Utils\Service\JWTService;

class AuthRepository {
    private $pdo, $table;

    public function __construct(ContainerInterface $container) {
        $this->pdo = $container->get('pdo');
        $this->table = 'login';
    }

    public function Login(array $payloadData): AuthUserModel {
        $data = Converter::ToObject($payloadData);

        $md5Password = md5($data->password);

        $isEmailRecord = $this->pdo->table($this->table)->where('email', $data->email)->get();
        Validator::IsTrue(empty($isEmailRecord), 'Email is not registered.');

        $isLoginRecord = $this->pdo->table($this->table)->where('email', $data->email)->where('password', $md5Password)->get();
        Validator::IsTrue(empty($isLoginRecord), 'Password is not valid.');

        $record = $this->pdo->table('users')->where('email', $isLoginRecord->email)->get();
        $record->token = JWTService::CreateToken($record);
        return new AuthUserModel($record);

    }

    public function Register(array $payloadData): AuthUserModel {
        $data = Converter::ToObject($payloadData);

        $isEmailRecord = $this->pdo->table($this->table)->where('email', $data->email)->get();
        Validator::IsTrue(!empty($isEmailRecord), 'Email is already registered.');

        $uniqId = Generator::UniqId($this->table);
        $uniqUserId = Generator::UniqId('users');

        $md5Password = md5($data->password);

        $dataForLogin = [
            'id' => $uniqId,
            'userId' => $uniqUserId,
            'email' => $data->email,
            'password' => $md5Password,
        ];

        $dataForUser = [
            'id' => $uniqUserId,
            'userName' => $data->userName,
            'email' => $data->email,
            'role' => 'user',
        ];

        $this->pdo->table($this->table)->insert(Converter::ToCreateArray($dataForLogin));
        $this->pdo->table('users')->insert(Converter::ToCreateArray($dataForUser));

        $record = $this->pdo->table('users')->where('email', $data->email)->get();
        $record->token = JWTService::CreateToken($record);
        return new AuthUserModel($record);

    }

    public function AutoLogin(string $jwtHeader): AuthUserModel {
        $jwtToken = end(explode('Bearer ', $jwtHeader));

        $data = JWTService::DecodeToken($jwtToken);

        $isEmailRecord = $this->pdo->table($this->table)->where('email', $data->email)->get();
        Validator::IsTrue(empty($isEmailRecord), 'Email is not registered.');

        $isTokenTrue = $this->pdo->table($this->table)->where('email', $data->email)->where('userId', $data->userId)->get();
        Validator::IsTrue(empty($isTokenTrue), 'Token is not valid.');

        $record = $this->pdo->table('users')->where('email', $data->email)->get();
        $record->token = JWTService::CreateToken($record);
        return new AuthUserModel($record);

    }

}