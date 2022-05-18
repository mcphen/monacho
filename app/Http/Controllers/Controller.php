<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Matiere;
use App\Models\Annee;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function sendResponse($status, $message, $data = null, $status_code = 200)
    {
        $response_content = [
            "Status" => $status,
            "Message" => $message,
            "Data" => $data
        ];

        return response()->json($response_content, $status_code);
    }

    public static function generateCode()
    {
        $randomString = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 8);
        return $randomString;
    }

    public static function makeImageName($intitule, $file_name, $sujet_code)
    {
        return strtolower(implode(explode(" ", $intitule))) . "_" . $file_name . "_" . $sujet_code;
    }

    public static function getMatiereName($id)
    {
        $matiere = Matiere::find($id);
        return $matiere->intitulé;
    }

    public static function getAnneeId($intitulé)
    {
        $annee = Annee::where("intitulé", "=", $intitulé)->get();
        $data = count($annee) == 0? null:$annee[0]->id;
        return $data;
    }
}
