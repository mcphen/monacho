<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeSujet;
use Exception;
class TypeSujetController extends Controller
{
    public function create(Request $request)
    {
        $type_sujet = new TypeSujet();
        $type_sujet->intitulé = $request->intitulé;
        $type_sujet->code = Controller::generateCode();
        try {
            $type_sujet->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $type_sujet);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function all()
    {
        $typeSujets = TypeSujet::all();
        if (count($typeSujets) != 0) {
            return json_encode($typeSujets);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function index(Request $request)
    {
        $typeSujet = TypeSujet::find($request->id);
        try {
            return json_encode($typeSujet);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function update(Request $request)
    {
        $typeSujet = TypeSujet::find($request->id);
        $request->intitulé == null ? : $typeSujet->intitulé = $request->intitulé;
        try {
            $typeSujet->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $typeSujet);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
