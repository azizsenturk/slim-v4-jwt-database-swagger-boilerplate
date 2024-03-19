<?php

declare (strict_types = 1);

namespace App\Repository;

use App\Model\User\UserModel;
use Psr\Container\ContainerInterface;
use Utils\Libs\Converter;
use Utils\Libs\Validator;
use Utils\Service\Generator;

class UserRepository {
    private $pdo, $table;

    public function __construct(ContainerInterface $container) {
        $this->pdo = $container->get('pdo');
        $this->table = 'users';
    }

    public function GetAll(): array {

        $itemList = $this->pdo->table($this->table)->getAll();

        $recordList = [];
        foreach ($itemList as $item) {
            $recordList[] = new UserModel($item);
        }

        return $recordList;

    }

    public function GetSingle(string $id): UserModel {

        $record = $this->pdo->table($this->table)->where('id', $id)->get();
        return new UserModel($record);

    }

    public function Create(array $payloadData): UserModel {
        $data = Converter::ToObject($payloadData);

        $unidId = Generator::UniqId($this->table);
        $data->id = $unidId;

        $this->pdo->table($this->table)->insert(Converter::ToCreateArray($data));

        $record = $this->pdo->table($this->table)->where('id', $unidId)->get();
        return new UserModel($record);

    }

    public function Update(array $payloadData): UserModel {
        $data = Converter::ToObject($payloadData);

        $this->pdo->table($this->table)->where('id', $data->id)->update(Converter::ToUpdateArray($data));

        $record = $this->pdo->table($this->table)->where('id', $data->id)->get();
        return new UserModel($record);

    }

    public function Delete(string $id) {

        $record = $this->pdo->table($this->table)->where('id', $id)->get();
        Validator::Required($record->id, 'Record not found.');

        $this->pdo->table($this->table)->where('id', $id)->delete();
        return null;

    }

}