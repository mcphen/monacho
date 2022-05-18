<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;
use Exception;
class ExamenController extends Controller
{
    public function create(Request $request)
    {
        $examen = new Examen();
        $examen->intitulé = $request->intitulé;
        $examen->code = Controller::generateCode();
        try {
            $examen->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $examen);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function all()
    {
        $examens = Examen::all();
        if (count($examens) != 0) {
            return json_encode($examens);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function index(Request $request)
    {
        $examen = Examen::find($request->id);
        try {
            return json_encode($examen);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function update(Request $request)
    {
        $examen = Examen::find($request->id);
        $request->intitulé == null ? : $examen->intitulé = $request->intitulé;
        try {
            $examen->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $examen);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
