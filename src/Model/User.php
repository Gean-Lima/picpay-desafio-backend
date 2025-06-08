<?php

namespace Neo\PicpayDesafioBackend\Model;

class UserModel extends Model
{
    protected string $tableName = 'users';

    protected array $fields = [
        'id',
        'name',
        'cpf_cnpj',
        'email',
        'password'
    ];
}
