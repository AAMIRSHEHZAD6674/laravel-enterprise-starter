<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface  extends BaseServiceInterface
{
    public function register(array $data): User;

    public function search(array $filters);

    public function createUser(array $data);
}