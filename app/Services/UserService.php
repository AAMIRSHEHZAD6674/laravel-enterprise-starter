<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

    public function search(array $filters)
    {
        return $this->repository->search($filters);
    }

    public function createUser(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = $this->repository->createUser([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $user->assignRole($data['role']);

            return $user;
        });
    }
}