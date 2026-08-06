<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->repository->create($data);
    }
}