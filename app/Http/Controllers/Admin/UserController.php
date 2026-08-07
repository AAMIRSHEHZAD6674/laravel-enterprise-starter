<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserServiceInterface;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->paginateUsers(
            $request->only(['search', 'role', 'status'])
        );

        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
        {
            $this->authorize('create', User::class);

            $roles = Role::orderBy('name')->get();

            return view('admin.users.create', compact('roles'));
        }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('viewAny', User::class);
        $this->userService->createUser(
            $request->validated()
        );
        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = Role::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
    $this->authorize('viewAny', User::class);    
    $this->userService->updateUser(
            $user,
            $request->validated()
        );
        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        // Prevent deleting yourself
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the last Super Admin
        if ($user->hasRole('Super Admin')) {

            $superAdminCount = \App\Models\User::role('Super Admin')->count();

            if ($superAdminCount <= 1) {
                return back()->with(
                    'error',
                    'The last Super Admin cannot be deleted.'
                );
            }
        }

        $this->userService->softDelete($user);

        return back()->with(
            'success',
            'User deleted successfully.'
        );
    }

    public function trash()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->userService->getTrashed();

        return view('admin.users.trash', compact('users'));
    }

    public function restore($id)
    {
        $this->authorize('viewAny', User::class);
        $this->userService->restore($id);

        return redirect()
            ->route('users.trash')
            ->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $this->authorize('viewAny', User::class);
        $this->userService->forceDelete($id);

        return redirect()
            ->route('users.trash')
            ->with('success', 'User permanently deleted.');
    }

    public function toggleStatus(User $user)
    {
        $this->authorize('update', $user);

        if (auth()->id() === $user->id) {
            return back()->with(
                'error',
                'You cannot deactivate your own account.'
            );
        }

        $status = ! $user->status;

        $this->userService->updateStatus($user, $status);

        return back()->with(
            'success',
            $status
                ? 'User activated successfully.'
                : 'User deactivated successfully.'
        );
    }

}