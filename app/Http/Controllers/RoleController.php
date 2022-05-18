<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Exception;

class RoleController extends Controller
{
    public function all(){
        $roles = Role::all();
        return json_encode($roles);
    }

    public function create(Request $request)
    {
        $role = new Role();
        $role->role = $request->role;
        try {
            $role->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $role);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
