<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnneeController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\DownloadSujetController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\TypeSujetController;
use App\Http\Controllers\SujetController;
use App\Http\Controllers\TypeSessionController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['api']], function(){

    // AUTHENTICATION routes------------------------
    Route::post('auth/register', [UserController::class, 'register'])->name("User.register");
    Route::post('auth/login', [UserController::class, 'login'])->name("User.login");

    //----annee
    Route::post('annee/create', [AnneeController::class, 'create'])->name("Annee.create");
    Route::get('annee/all', [AnneeController::class, 'all'])->name("Annee.all");
    Route::post('annee/update', [AnneeController::class, 'update'])->name("Annee.update");
    Route::get('annee/index', [AnneeController::class, 'index'])->name("Annee.index");

    //----examen
    Route::post('examen/create', [ExamenController::class, 'create'])->name("Examen.create");
    Route::post('examen/update', [ExamenController::class, 'update'])->name("Examen.update");
    Route::get('examen/all', [ExamenController::class, 'all'])->name("Examen.all");
    Route::get('examen/index', [ExamenController::class, 'index'])->name("Examen.index");

    //----matiere
    Route::post('matiere/create', [MatiereController::class, 'create'])->name("Matiere.create");
    Route::get('matiere/all', [MatiereController::class, 'all'])->name("Matiere.all");
    Route::post('matiere/update', [MatiereController::class, 'update'])->name("Matiere.update");
    Route::get('matiere/index', [MatiereController::class, 'index'])->name("Matiere.index");

    //----
    Route::post('role/create', [RoleController::class, 'create'])->name("Role.create");
    Route::get('role/all', [RoleController::class, 'all'])->name("Role.all");

    //----sujet
    Route::post('sujet/create', [SujetController::class, 'create'])->name("Sujet.create");
    Route::get('sujet/all', [SujetController::class, 'all'])->name("Sujet.all");
    Route::post('sujet/update', [SujetController::class, 'update'])->name("Sujet.update");
    Route::get('sujet/index', [SujetController::class, 'index'])->name("Sujet.index");
    Route::post('sujet/search', [SujetController::class, 'search'])->name("Sujet.search");

    //----typeSession
    Route::post('typeSession/create', [TypeSessionController::class, 'create'])->name("TypeSession.create");
    Route::get('typeSession/all', [TypeSessionController::class, 'all'])->name("TypeSession.all");
    Route::post('typeSession/update', [TypeSessionController::class, 'create'])->name("TypeSession.update");
    Route::get('typeSession/index', [TypeSessionController::class, 'index'])->name("TypeSession.index");

    //----typeSujet
    Route::post('typeSujet/create', [TypeSujetController::class, 'create'])->name("TypeSujet.create");
    Route::get('typeSujet/all', [TypeSujetController::class, 'all'])->name("TypeSujet.all");
    Route::post('typeSujet/update', [TypeSujetController::class, 'update'])->name("TypeSujet.update");
    Route::get('typeSujet/index', [TypeSujetController::class, 'index'])->name("TypeSujet.index");

    //----serie
    Route::post('serie/create', [SerieController::class, 'create'])->name("Serie.create");
    Route::get('serie/all', [SerieController::class, 'all'])->name("Serie.all");
    Route::get('serie/update', [SerieController::class, 'update'])->name("Serie.update");
    Route::get('serie/index', [SerieController::class, 'index'])->name("Serie.index");

    //----downloads
    Route::post('download/create', [DownloadSujetController::class, 'create'])->name("DownloadSujet.create");
    Route::get('download/all', [DownloadSujetController::class, 'all'])->name("DownloadSujet.all");
    Route::get('download/sujet', [DownloadSujetController::class, 'sujet_downloads'])->name("DownloadSujet.sujet_downloads");
});
