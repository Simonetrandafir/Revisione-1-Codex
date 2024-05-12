<?php

use App\Helpers\AppHelpers;
use App\Http\Controllers\Api\v1\AbilitaController;
use App\Http\Controllers\Api\v1\AccediController;
use App\Http\Controllers\Api\v1\CalcoloIva;
use App\Http\Controllers\Api\v1\CategorieController;
use App\Http\Controllers\Api\v1\ComuniItalianiController;
use App\Http\Controllers\Api\v1\ConfigurazioniController;
use App\Http\Controllers\Api\v1\ContattiController;
use App\Http\Controllers\Api\v1\CreditiController;
use App\Http\Controllers\Api\v1\EpisodiController;
use App\Http\Controllers\Api\v1\FilesImgController;
use App\Http\Controllers\Api\v1\FilmController;
use App\Http\Controllers\Api\v1\GenereController;
use App\Http\Controllers\Api\v1\LingueController;
use App\Http\Controllers\Api\v1\NazioniController;
use App\Http\Controllers\Api\v1\RegistraController;
use App\Http\Controllers\Api\v1\RuoliController;
use App\Http\Controllers\Api\v1\SerieTvController;
use App\Http\Controllers\Api\v1\StatiController;
use App\Http\Controllers\Api\v1\TipoIndirizziController;
use App\Http\Controllers\Api\v1\TipoRecapitiController;
use App\Http\Controllers\Api\v1\TraduzioniController;
use App\Http\Controllers\Api\v1\TraduzioniCustomController;
use App\Http\Controllers\Api\v1\VistaProvinceController;
use App\Http\Controllers\Api\v1\VistaTraduzioniController;
use App\Http\Controllers\Api\v1\IndirizziController;
use App\Http\Controllers\Api\v1\PasswordController;
use App\Http\Controllers\Api\v1\RecapitiController;
use App\Http\Controllers\Api\v1\FilesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//------------------------------------------COSTANTI------------------------------------------------
//VERSIONE -> costante = v1
if (!defined('VERSIONE')){
    define('VERSIONE','v1');
}
//AGGIORNA -> costante = v1
if (!defined('AGGIORNA')){
    define('AGGIORNA','/aggiorna');
}
//DISTRUGGI -> costante = v1
if (!defined('DISTRUGGI')){
    define('DISTRUGGI','/distruggi');
}
//SALVA -> costante = v1
if (!defined('SALVA')){
    define('SALVA','/salva');
}
//CONTATTO_ID -> costante = v1
if (!defined('CONTATTO_ID')){
    define('CONTATTO_ID','/contatti/{idContatto}');
}
//CATEGORIA_ID -> costante = v1
if (!defined('CATEGORIA_ID')){
    define('CATEGORIA_ID','/categorie/{idCategoria}');
}
//FILM_ID -> costante = v1
if (!defined('FILM_ID')){
    define('FILM_ID','/films/{film}');
}
//GENERE_ID -> costante = v1
if (!defined('GENERE_ID')){
    define('GENERE_ID','/generi/{idGenere}');
}
//TIPOINDIRIZZO_ID -> costante = v1
if (!defined('TIPOINDIRIZZO_ID')){
    define('TIPOINDIRIZZO_ID','/tipoIndirizzi/{idTipoIndirizzo}');
}
//CONFIG_ID -> costante = v1
if (!defined('CONFIG_ID')){
    define('CONFIG_ID','/config/{idConfigurazione}');
}
//SERIE_ID -> costante = v1
if (!defined('SERIE_ID')){
    define('SERIE_ID','/serieTv/{idSerieTv}');
}
//EPISODI_ID -> costante = v1
if (!defined('EPISODI_ID')){
    define('EPISODI_ID','/episodi/{idEpisodio}');
}


//!------------------------------------ TEST ---------------------------------------------------------
//---------------------------------------------------- TEST ----------------------------------------------------
Route::get(VERSIONE . '/testLogin/admin', function () {
    $hashUsername='b65f3239ff11929e77029d607bd566d4f21fa36f44874313da0fa746f202fe42f581e569f1aeda5ac51327a4bf64b3058ec450e85c4fdd219e955d083ae35c7f';
    $hashEmail = "7d0b953f8bcd9ad869b18651d5e80ae51734dcdf15755a5896e0145114c92718b254178ec579ece7cd47abf01378d4bf7fedf6f1c878395dc5486db23cd81c79";
    $psw = "cae167b89dca819271e9644b7c2807d9504f73fbd0e8553fa9ef3f83656ebb6e94ead7e819c3a424e5c5045e063f60365b42fda9ddb147724db984a24d367500";
    //effettua login e insiresci qui sale
    $sale = "825b45433a3fc059d9314e730ecae7a500837833268728e6898f73309c9425774fda7249477bb1baaa6ae59ccfe3311866157af1d783092fad16e5ef6ca4db57";
    
    $hashSalePsw = AppHelpers::nascondiPassword($psw, $sale);
    
    AccediController::testLogin($hashUsername,$hashEmail, $hashSalePsw);
    
});
Route::get(VERSIONE . '/testLogin/utente', function () {
    $hashUsername='547b32da8ab3cd7ecfca311aafb048d9532bc38ddba013be808572d0911a5292162f97371127d3b4f43752dd0e0748a99d4f3c263e6fe9ae92e7c4041b33c3bc';
    $hashEmail = "f9ea35bdeab9c8a039682f0fd2a49f437e5503e100cef907d10f409555bf9b6ec55db861a52744f8fe417e672ae820f13213790bffa5f50b5f28885840ee40f2";
    $psw = "a06c15a9cbdc427e399a27efb407a8668130a034494cf462a2ef8571a57fe5b7385249954bb307789362fe18fa418b4a8bff87c7e9d1bc2e9d22d7b6c7b919e3";
    //effettua login e insiresci qui sale
    $sale = "06405151c0c5b18ef29f3784e467bd4a5a459b10b973d5b96a7d9bd8912f811cedf66ab7ef78c3a76cde190b38d4041631485e0fbe080556923a8d3dd879a62e";
    
    $hashSalePsw = AppHelpers::nascondiPassword($psw, $sale);
    
    AccediController::testLogin($hashUsername,$hashEmail, $hashSalePsw);
});
//!------------------------------------ TEST ---------------------------------------------------------

//?---------------------------------------------------ENDPOINT---------------------------------------

//*-------------------------------------------------- ACCESSO : TUTTI -------------------------------------------------
//---------------------- REGISTRA -----------------------------------------------tested //TODO: RE-WORK
Route::post(VERSIONE . '/registra', [RegistraController::class,'registra']);

//----------------------ACCEDI----------------------------------------------------tested
Route::get(VERSIONE . '/accedi/{username}/{email}/{hash?}',[AccediController::class, 'accedi']);

//-----------COMUNI ITALIANI----------------------------------------tested
Route::get(VERSIONE . '/comuniItaliani', [ComuniItalianiController::class,'index']);

// --------------------- NAZIONI ------------------------------------tested
Route::get(VERSIONE . '/nazioni', [NazioniController::class,'index']);
Route::get(VERSIONE . '/nazioni/{idNazione}', [NazioniController::class,'show']);

//------------------------ TIPO INDIRIZZI ---------------------------------------------- tested
Route::get(VERSIONE . '/tipoIndirizzi',[TipoIndirizziController::class, 'index']);
Route::get(VERSIONE . TIPOINDIRIZZO_ID,[TipoIndirizziController::class, 'show']);

// --------------------- LINGUE ------------------------------------------------- tested
Route::get(VERSIONE . '/lingue',[LingueController::class,'index']);
Route::get(VERSIONE . '/lingue/{idLingua}',[LingueController::class,'show']);
// --------------------- TRADUZIONI VISTA ------------------------------------------------- tested
Route::get(VERSIONE . '/vista/traduzioni',[VistaTraduzioniController::class,'index']);
Route::get(VERSIONE . '/vista/traduzioni/{id}',[VistaTraduzioniController::class,'show']);
// ---------------------- TIPO RECAPITI ----------------------------------------------------- tested
Route::get(VERSIONE . '/tipo-recapiti',[TipoRecapitiController::class,'index']);
Route::get(VERSIONE . '/tipo-recapiti/{idTipoRecapito}',[TipoRecapitiController::class,'show']);
// ------------------------------------ CONFIGURAZIONI -----------------------------tested
Route::get(VERSIONE . '/config', [ConfigurazioniController::class,'index']);
Route::get(VERSIONE . CONFIG_ID, [ConfigurazioniController::class,'show']);
// ----------------------------------- RUOLI  -----------------------------------tested
Route::get(VERSIONE . '/ruoli', [RuoliController::class,'index']);
Route::get(VERSIONE . '/ruoli/{idRuolo}', [RuoliController::class,'show']);

//------------------------------------ABILITA----------------------------------testede
Route::get(VERSIONE . '/abilita',[AbilitaController::class, 'index']);
Route::get(VERSIONE . '/abilita/{idAbilita}',[AbilitaController::class, 'show']);

// --------------------------------------- STATI --------------------------------testde
Route::get(VERSIONE . '/stati', [StatiController::class,'index']);
Route::get(VERSIONE . '/stati/{idStato}', [StatiController::class,'show']);
//---------------------------------- VISTA PROVINCE -------------------------tested
Route::get(VERSIONE . '/province',[VistaProvinceController::class,'index']);
Route::get(VERSIONE . '/province/{provincia}',[VistaProvinceController::class,'show']);

//!---------------------------------------------------------------------------------------------------------------------

//-------------------------- UPLOAD FILE IMG----------------------------------------------------------------------
Route::post(VERSIONE.'/salva/upload',[FilesImgController::class,'store']);

//TODO:--------------ALTRO---------------------------------------------- Fallita
Route::get(VERSIONE . '/calcoloIva/{numero}',[CalcoloIva::class,'calcolaIva']);
//!--------------------------------------------------------------------------------------------------------------

//?#################################################################################################################

//* ---------------------------------------- API ACCESSO : ADMIN, UTENTE -----------------------------------------------
Route::middleware(["autenticazione", "ruoli:admin,utente"])->group(function(){
    //-------------------CATEGORIE----------------------------------------tested
    Route::get(VERSIONE.'/categorie',[CategorieController::class, 'index']);
    Route::get(VERSIONE.CATEGORIA_ID,[CategorieController::class, 'show']);

    //------------------GENERE----------------------------------------------------------tested
    Route::get(VERSIONE . '/generi', [GenereController::class, 'index']);
    Route::get(VERSIONE . GENERE_ID, [GenereController::class, 'show']);
    
    // ------------------------- CONTATTO ---------------------------------------------tested
    Route::get(VERSIONE . CONTATTO_ID, [ContattiController::class,'show']);
    Route::put(VERSIONE . AGGIORNA . CONTATTO_ID, [ContattiController::class,'update']);

    // ------------------------- FILM -------------------------------------tested
    Route::get(VERSIONE . '/films', [FilmController::class,'index']);
    Route::get(VERSIONE . '/films/genere/{idGenere}', [FilmController::class,'indexGenere']);
    Route::get(VERSIONE . '/films/regista/{regista}', [FilmController::class,'indexRegista']);
    Route::get(VERSIONE . '/films/anno/{anno}', [FilmController::class,'indexAnno']);
    Route::get(VERSIONE . FILM_ID, [FilmController::class,'show']);

    // ------------------------- SERIE TV -------------------------------------tested
    Route::get(VERSIONE . '/serieTv', [SerieTvController::class,'index']);
    Route::get(VERSIONE . '/serieTv/genere/{idGenere}', [SerieTvController::class,'indexGenere']);
    Route::get(VERSIONE . '/serieTv/regista/{regista}', [SerieTvController::class,'indexRegista']);
    Route::get(VERSIONE . '/serieTv/anno/{anno}', [SerieTvController::class,'indexAnno']);
    Route::get(VERSIONE . SERIE_ID, [SerieTvController::class,'show']);

    // ------------------------- EPISODI -------------------------------------tested
    Route::get(VERSIONE . '/episodi/{idEpisodio}', [EpisodiController::class,'showEpisodio']);
    Route::get(VERSIONE . '/serieTv/{idSerieTv}/episodi', [EpisodiController::class,'episodiSerieTv']);

    // -------------------------- CREDITI ---------------------------------------tested
    Route::get(VERSIONE . '/crediti/{idContatto}', [CreditiController::class,'show']);
    Route::put(VERSIONE . AGGIORNA .'/crediti/{idContatto}', [CreditiController::class,'update']);

    // -------------------------- FILES ---------------------------------------------------------tested
    Route::get(VERSIONE .'/files/{idFile}',[FilesController::class,'show']);

    //------------------------------- INDIRIZZI ----------------------------------------tested
    Route::get(VERSIONE .'/indirizzi/{idContatto}',[IndirizziController::class,'indexUtente']);
    Route::post(VERSIONE.SALVA .'/indirizzi/{idContatto}',[IndirizziController::class,'aggiungiIndirizzo']);
    Route::get(VERSIONE . '/indirizzi/{idContatto}/{idIndirizzo}',[IndirizziController::class,'show']);
    Route::put(VERSIONE .AGGIORNA. '/indirizzi/{idContatto}/{idIndirizzo}',[IndirizziController::class,'update']);
    Route::delete(VERSIONE .DISTRUGGI. '/indirizzi/{idContatto}/{idIndirizzo}',[IndirizziController::class,'destroy']);
    //------------------------------- RECAPITI ----------------------------------------tested
    Route::get(VERSIONE . '/recapiti/{idContatto}',[RecapitiController::class,'show']);
    Route::post(VERSIONE .SALVA. '/recapiti/{idContatto}',[RecapitiController::class,'aggiungiRecapito']);
    Route::put(VERSIONE .AGGIORNA. '/recapiti/{idContatto}/{idRecapito}',[RecapitiController::class,'update']);
    Route::delete(VERSIONE .DISTRUGGI. '/recapiti/{idContatto}/{idRecapito}',[RecapitiController::class,'destroy']);
    
    //--------------------------- PASSWORDS ---------------------------------------------tested
    Route::post(VERSIONE .SALVA .'/passwords/{idContatto}',[PasswordController::class,'aggiungiPassword']);
    Route::put(VERSIONE . AGGIORNA . '/passwords/{idContatto}',[PasswordController::class,'update']);
});

//?#################################################################################################################

//*--------------------------------------- API ACCESSO : ADMIN --------------------------------------------
Route::middleware(["autenticazione", "ruoli:admin"])->group(function(){
    
    //------------------------- CONTATTI ----------------------------------tested
    Route::get(VERSIONE . '/contatti', [ContattiController::class,'index']);
    Route::delete(VERSIONE .DISTRUGGI. CONTATTO_ID, [ContattiController::class,'destroy']);//! Distrugge anche i campi collegati al contatto selezionato
    
    //------------------GENERE----------------------------------------------------------tested
    Route::post(VERSIONE . SALVA .'/generi',[GenereController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA. GENERE_ID,[GenereController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. GENERE_ID,[GenereController::class, 'destroy']);
    
    //-------------------CATEGORIE----------------------------------------tested
    Route::post(VERSIONE . SALVA.'/categorie',[CategorieController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA.CATEGORIA_ID,[CategorieController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. CATEGORIA_ID,[CategorieController::class, 'destroy']);
    
    // --------------------------- FILM --------------------------------------------tested
    Route::post(VERSIONE . SALVA .'/films', [FilmController::class,'store']);
    Route::put(VERSIONE . AGGIORNA . FILM_ID, [FilmController::class,'update']);
    Route::delete(VERSIONE . DISTRUGGI . FILM_ID, [FilmController::class,'destroy']);

    // ------------------------- SERIE TV -------------------------------------tested
    Route::post(VERSIONE . SALVA .'/serieTv', [SerieTvController::class,'store']);
    Route::put(VERSIONE . AGGIORNA . SERIE_ID, [SerieTvController::class,'update']);
    Route::delete(VERSIONE . DISTRUGGI . SERIE_ID, [SerieTvController::class,'destroy']);

    // ------------------------- EPISODI -------------------------------------tested
    Route::get(VERSIONE . '/episodi', [EpisodiController::class,'index']);
    Route::post(VERSIONE . SALVA .'/episodi', [EpisodiController::class,'store']);
    Route::put(VERSIONE .AGGIORNA. EPISODI_ID, [EpisodiController::class,'update']);
    Route::delete(VERSIONE .DISTRUGGI. EPISODI_ID, [EpisodiController::class,'destroy']);


    // ------------------------------------ CONFIGURAZIONI -----------------------------tested
    Route::post(VERSIONE . SALVA .'/config',[ConfigurazioniController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA. CONFIG_ID,[ConfigurazioniController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. CONFIG_ID,[ConfigurazioniController::class, 'destroy']);

    //------------------------ TIPO INDIRIZZI ----------------------------- tested
    Route::post(VERSIONE . SALVA .'/tipoIndirizzi',[TipoIndirizziController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA. TIPOINDIRIZZO_ID,[TipoIndirizziController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. TIPOINDIRIZZO_ID,[TipoIndirizziController::class, 'destroy']);

    //------------------------ INDIRIZZI -----------------------------------------------------
    Route::get(VERSIONE .'/indirizzi',[IndirizziController::class,'index']);
    //------------------------ RECAPITI -----------------------------------------------------
    Route::get(VERSIONE .'/recapiti',[RecapitiController::class,'index']);

    // --------------------- LINGUE ------------------------------------------------- 
    Route::post(VERSIONE . SALVA .'/lingue',[LingueController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA. '/lingue/{idLingua}',[LingueController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. '/lingue/{idLingua}',[LingueController::class, 'destroy']);

    // --------------------- TRADUZIONI -------------------------------------------------
    Route::post(VERSIONE . SALVA .'/traduzioni',[TraduzioniController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA. '/traduzioni/{idTraduzione}',[TraduzioniController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. '/traduzioni/{idTraduzione}',[TraduzioniController::class, 'destroy']);

    // --------------------- TRADUZIONI CUSTOMS -------------------------------------------------
    Route::post(VERSIONE . SALVA .'/traduzioni-customs',[TraduzioniCustomController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA. '/traduzioni-customs/{idTraduzione}',[TraduzioniCustomController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. '/traduzioni-customs/{idTraduzione}',[TraduzioniCustomController::class, 'destroy']);

    // --------------------- TIPO RECAPITI -------------------------------------------------
    Route::post(VERSIONE . SALVA .'/tipo-recapiti',[TipoRecapitiController::class, 'store']);
    Route::put(VERSIONE .AGGIORNA. '/tipo-recapiti/{idTipoRecapito}',[TipoRecapitiController::class, 'update']);
    Route::delete(VERSIONE .DISTRUGGI. '/tipo-recapiti/{idTipoRecapito}',[TipoRecapitiController::class, 'destroy']);

    // -------------------------- CREDITI ---------------------------------------
    Route::get(VERSIONE . '/crediti', [CreditiController::class,'index']);

    // -------------------------- FILES ---------------------------------------------------------
    Route::get(VERSIONE .'/files',[FilesController::class,'index']);
    // Route::post(VERSIONE . SALVA .'/files',[FilesController::class,'store']);
    Route::put(VERSIONE .AGGIORNA .'/files/{idFile}',[FilesController::class,'update']);
    Route::delete(VERSIONE.DISTRUGGI .'/files/{idFile}',[FilesController::class,'destroy']);
    //-------------------------- PASSWORDS ---------------------------------
    Route::get(VERSIONE . '/passwords',[PasswordController::class,'index']);
});

//#################################################################################################################



