<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function search(array $filters);

    public function createUser(array $data);

    public function updateUser(User $user, array $data): bool;
}
