<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serie;
use Exception;

class SerieController extends Controller
{
    public function create(Request $request)
    {
        $serie = new Serie();
        $serie->intitulé = $request->intitulé;
        $serie->code = Controller::generateCode();
        try {
            $serie->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $serie);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function all()
    {
        $series = Serie::all();
        if (count($series) != 0) {
            return json_encode($series);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function index(Request $request)
    {
        $serie = Serie::find($request->id);
        try {
            return json_encode($serie);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function update(Request $request)
    {
        $serie = Serie::find($request->id);
        $request->intitulé == null ? : $serie->intitulé = $request->intitulé;
        try {
            $serie->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $serie);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
