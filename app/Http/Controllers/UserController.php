<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {

            $valid_credentials = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if ($valid_credentials) {
                $message = [
                    "en" => "User Successfully Authenticated",
                    "fr" => "Connexion réussie !"
                ];

                return Controller::sendResponse("SUCCESS", $message, Auth::user());
            } else {
                $message = [
                    "en" => "Invalid Credentials",
                    "fr" => "Identifiants incorrects, veuillez réessayer !"
                ];

                return Controller::sendResponse("ERROR", $message,null,400);
            }
        } catch (Exception $e) {

            $message = [
                "en" => "Error Authenticating User " . $e->getMessage(),
                "fr" => "Une erreur innatendue est survenue lors de la tentative de connexion, merci de réessayer " . $e->getMessage()
            ]; // $e->getMessage() is just for dev purposes, to remove once in prod

            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function register(Request $request) // used to register a Handler
    {

        $user = new User();
        $user->email = $request->email;
        $user->role_id = Role::all()[0]['id'];
        $user->password = Hash::make($request->password);

        try {
            $user->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $user);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

}
