<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DownloadSujet;
use Exception;

class DownloadSujetController extends Controller
{
    public function create(Request $request)
    {
        $dwnsujet = new DownloadSujet();
        $dwnsujet->adress_ip = $request->ip();
        $dwnsujet->sujet_id = $request->sujet_id;
        try {
            $dwnsujet->save();
            $message = "success";
            return Controller::sendResponse("SUCCESS", $message, $dwnsujet);
        } catch (Exception $e) {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function all()
    {
        $downloads = DownloadSujet::all();
        if (count($downloads) != 0) {
            return json_encode($downloads);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }

    public function sujet_downloads(Request $request)
    {
        $downloads = DownloadSujet::where('sujet_id', '=', $request->sujet_id)->get();
        $downloads_number = count($downloads);
        if ($downloads_number != 0) {
            $message = "success";
            $info = array(
                "users"=>$downloads,
                "downloads_number"=>$downloads_number
            );
            return Controller::sendResponse("SUCCESS", $message, $info);
        } else {
            $message = "Something went wrong";
            return Controller::sendResponse("ERROR", $message,null,400);
        }
    }
}
