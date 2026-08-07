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

    public function updateUser(User $user, array $data): bool
    {
        return DB::transaction(function () use ($user, $data) {

            $updated = $this->repository->updateUser($user, [
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            $user->syncRoles([$data['role']]);

            return $updated;
        });
    }

    public function softDelete(User $user): bool
    {
        return $this->repository->softDelete($user);
    }

    public function restore(int $id): bool
    {
        return $this->repository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->repository->forceDelete($id);
    }

    public function getTrashed()
    {
        return $this->repository->getTrashed();
    }

    public function paginateUsers(array $filters = [],int $perPage = 10) 
    {
        return $this->repository->paginateUsers(
            $filters,
            $perPage
        );
    }

    public function updateStatus(User $user, bool $status): bool
    {
        return $this->repository->updateStatus($user, $status);
    }
}