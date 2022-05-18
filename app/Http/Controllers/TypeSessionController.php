<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeSession;
use Exception;

class TypeSessionController extends Controller
{
    public function create(Request $request)
    {
        $type_session = new TypeSession();
        $type_session->intitulé = $request->intitulé;
        $type_session->code = Controller::generateCode();
        try {
            $type_session->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $type_session);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function all()
    {
        $typeSessions = TypeSession::all();
        if (count($typeSessions) != 0) {
            return json_encode($typeSessions);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function index(Request $request)
    {
        $typeSession = TypeSession::find($request->id);
        try {
            return json_encode($typeSession);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function update(Request $request)
    {
        $typeSession = TypeSession::find($request->id);
        $request->intitulé == null ? : $typeSession->intitulé = $request->intitulé;
        try {
            $typeSession->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $typeSession);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
