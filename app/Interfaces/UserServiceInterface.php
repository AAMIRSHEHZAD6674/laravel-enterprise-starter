<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface  extends BaseServiceInterface
{
    public function register(array $data): User;
}