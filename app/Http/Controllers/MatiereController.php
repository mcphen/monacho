<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matiere;
use Exception;

class MatiereController extends Controller
{
    public function create(Request $request)
    {
        $matiere = new Matiere();
        $matiere->intitulé = $request->intitulé;
        $matiere->code = Controller::generateCode();
        try {
            $matiere->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $matiere);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function all()
    {
        $matieres = Matiere::all();
        if (count($matieres) != 0) {
            return json_encode($matieres);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function index(Request $request)
    {
        $matiere = Matiere::find($request->id);
        try {
            return json_encode($matiere);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function update(Request $request)
    {
        $matiere = Matiere::find($request->id);
        $request->intitulé == null ? : $matiere->intitulé = $request->intitulé;
        try {
            $matiere->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $matiere);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
