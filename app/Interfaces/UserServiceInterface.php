<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    public function register(array $data): User;
}