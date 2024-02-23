<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleListController extends Controller
{
    public function __invoke()
    {
        $roles = Role::all();
        return view('role.list', ['roles' => $roles]);
    }
}
