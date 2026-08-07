<?php

namespace App\Interfaces;

use App\Models\User;

interface UserServiceInterface  extends BaseServiceInterface
{
    public function register(array $data): User;

    public function search(array $filters);

    public function createUser(array $data);

    public function updateUser(User $user, array $data): bool;

    public function softDelete(User $user): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;

    public function getTrashed();

    public function updateStatus(User $user, bool $status): bool;
}