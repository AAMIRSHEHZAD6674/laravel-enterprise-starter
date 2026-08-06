<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserServiceInterface;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\StoreUserRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    public function index(UserSearchRequest $request)
    {
        $users = $this->userService->search(
            $request->validated()
        );

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser(
            $request->validated()
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }
}