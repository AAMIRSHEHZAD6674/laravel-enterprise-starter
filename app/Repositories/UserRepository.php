<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model
            ->where('email', $email)
            ->first();
    }

    public function search(array $filters)
    {
        return $this->model
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($filters['role'] ?? null, function ($query, $role) {
                $query->role($role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function createUser(array $data)
    {
        return $this->model->create($data);
    }

    public function updateUser(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function softDelete(User $user): bool
    {
        return $user->delete();
    }

    public function restore(int $id): bool
    {
        $user = User::withTrashed()->findOrFail($id);

        return $user->restore();
    }

    public function forceDelete(int $id): bool
    {
        $user = User::withTrashed()->findOrFail($id);

        return $user->forceDelete();
    }

    public function getTrashed()
    {
        return User::onlyTrashed()
            ->latest()
            ->paginate(10);
    }

    public function paginateUsers(array $filters = [], int $perPage = 10)
    {
        $query = User::with('roles')->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['role'])) {
            $query->role($filters['role']);
        }

        $status = $filters['status'] ?? null;

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function updateStatus(User $user, bool $status): bool
    {
        return $user->update([
            'status' => $status,
        ]);
    }

}