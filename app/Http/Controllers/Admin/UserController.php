<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserServiceInterface;

class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    public function index()
    {
        $users = $this->userService->paginate(10);

        return view('admin.users.index', compact('users'));
    }
}