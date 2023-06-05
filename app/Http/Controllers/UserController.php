<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Tables\UsersTable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View{
/*         $users = UsersTable::class;
        return view('users.index', compact('users')); */

        return view('users.index', [
            'users' => UsersTable::class
        ]);
    }
}
