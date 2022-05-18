<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annee;
use Exception;
class AnneeController extends Controller
{
    public function create(Request $request)
    {
        $annee = new Annee();
        $annee->intitulé = $request->intitulé;
        $annee->code = Controller::generateCode();
        try {
            $annee->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $annee);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function all()
    {
        $annees = Annee::all();
        if (count($annees) != 0) {
            return json_encode($annees);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function index(Request $request)
    {
        $annee = Annee::find($request->id);
        try {
            return json_encode($annee);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function update(Request $request)
    {
        $annee = Annee::find($request->id);
        $annee->intitulé = $request->intitulé;
        try {
            $annee->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $annee);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
