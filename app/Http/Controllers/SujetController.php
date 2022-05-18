<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sujet;
use Exception;

class SujetController extends Controller
{
    public function create(Request $request)
    {
        $sujet = new Sujet();

        $sujet->intitulé = $request->intitulé;
        $sujet->annee_id = $request->annee_id;
        $sujet->examen_id = $request->examen_id;
        $sujet->type_session_id = $request->type_session_id;
        $sujet->type_sujet_id = $request->type_sujet_id;
        $sujet->serie_id = $request->serie_id;
        $sujet->matiere_id = $request->matiere_id;
        $sujet->code = Controller::generateCode();

        //if a file is provided
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $extension = $request->file('file_pdf')->extension();
            if ($extension == "txt" || $extension == "pdf"){
                //change image name if a new company name is provided
                $file_name = Controller::makeImageName($request->intitulé, $file->getClientOriginalName(), $sujet->code);
                $matiere_name = Controller::getMatiereName($sujet->matiere_id);
                $file->move(public_path("pdf/$matiere_name/"), $file_name);
                $sujet->file_pdf = "pdf/$matiere_name/$file_name";
            }else{
                $message = "File type must be a text or a pdf";
                return Controller::sendResponse("ERROR", $message,null,400);
            }


        }

        try {
            $sujet->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $sujet);
        } catch (Exception $e) {

        }
    }

    public function all()
    {
        $sujets = Sujet::all();
        if (count($sujets) != 0) {
            return json_encode($sujets);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function index(Request $request)
    {
        $sujet = Sujet::find($request->id);
        try {
            return json_encode($sujet);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function update(Request $request)
    {
        $sujet = Sujet::find($request->id);
        $request->intitulé == null ? : $sujet->intitulé = $request->intitulé;
        $request->examen_id == null ? : $sujet->examen_id = $request->examen_id;
        $request->type_session_id == null ? : $sujet->type_session_id = $request->type_session_id;
        $request->type_sujet_id == null ? : $sujet->type_sujet_id = $request->type_sujet_id;
        $request->serie_id == null ? : $sujet->serie_id = $request->serie_id;
        $request->matiere_id == null ? : $sujet->matiere_id = $request->matiere_id;
        try {
            $sujet->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $sujet);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function search(Request $request)
    {
        $search_scope = [];

        //get sujet in given annee
        $sujets_in = [];
        if($request->annees != null){
            $tab = explode(",", $request->annees);
            foreach ($tab as $intitulé) {
                $id = Controller::getAnneeId($intitulé);
                if($id != null){
                    $sujets_in[] = Sujet::where('annee_id', '=', $id)->get()[0];
                }

            }
        }

        //get sujet between fiven annee interval
        $sujets_between = [];
        if($request->interval != null){
            $tab = explode("-", $request->interval);
            for ($intitulé=intval($tab[0]); $intitulé<=intval($tab[1]); $intitulé++){
                $id = Controller::getAnneeId($intitulé);
                if($id != null){
                    $sujets_between[] = Sujet::where('annee_id', '=', $id)->get()[0];
                }

            }
        }

        //fusion of $sujets_in and $sujets_between
        $sujets_annees_interval = array_merge($sujets_in, $sujets_between);

        $condition_ultime = $request->interval != null && $request->annees != null;
        $request->annee_id == null || $condition_ultime? : $search_scope[]=['annee_id', '=', $request->annee_id];
        $request->code == null ? : $search_scope[]=['code', '=', $request->code];
        $request->serie_id == null ? : $search_scope[]=['serie_id', '=', $request->serie_id];
        $request->examen_id == null ? : $search_scope[]=['examen_id', '=', $request->examen_id];
        $request->type_session_id == null ? : $search_scope[]=['type_session_id', '=', $request->type_session_id];
        $request->type_sujet_id == null ? : $search_scope[]=['type_sujet_id', '=', $request->type_sujet_id];
        $request->matiere_id == null ? : $search_scope[]=['matiere_id', '=', $request->matiere_id];

        $sujets_normal = [];

        //get sujet in normal search
        if(count($search_scope) != 0){
            $sujets = Sujet::where($search_scope)->get();
            foreach ($sujets as $value){
                $sujets_normal[] = $value;
            }

        }

        //fusion of all result array
        $sujets_pas_final = array_merge($sujets_normal, $sujets_annees_interval);

        //delete all same value to get an array of uniques values
        $sujets_final = array_unique($sujets_pas_final);

        $number = count($sujets_final);

        if(count($search_scope) == 0 && $number == 0){
            $message = "Missing search scope";
            return Controller::sendResponse("ERROR", $message,null,400);
        }

        if ($number != 0) {
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $sujets_final);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
