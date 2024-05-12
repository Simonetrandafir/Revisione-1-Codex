<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Models\Nazioni;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\NazioniCollection;
use App\Http\Resources\v1\NazioniCompletoCollection;
use App\Http\Resources\v1\NazioniCompletoResource;
use App\Http\Resources\v1\NazioniResource;
use Illuminate\Support\Facades\DB;

class NazioniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nome = request("nome");
        $continente = request("continente");
        $iso = request('iso');
        $nazioni = Nazioni::all();

        if ($nome !== null) {
            // Se è fornito un ID, visualizza la singola nazione
            $nazioniQuery = Nazioni::query();
            $nazioniQuery->where('nome', $nome);
            $nazioni = $nazioniQuery->get();
            
        } elseif ($continente !== null) {
            $nazioniQuery = Nazioni::query();
            $nazioniQuery->where('continente', $continente);
            $nazioni = $nazioniQuery->get();
           
        }elseif ($iso !== null) {
            $nazioniQuery = Nazioni::query();
            $nazioniQuery->where('iso', $iso);
            $nazioni = $nazioniQuery->get();
           
        }
        return $this->creaCollection($nazioni);
    }

    public function show($idNazione){
        $nazione = $this->trovaIdDatabase($idNazione);
        return $this->creaRisorsa($nazione);
    }


    // -----------------------------------------------------------------------------//
    //          *****   PROTECTED   *****           //
    /**
     * Aggiorna id della tabella ricevendo la tabelle, l'id della tabella e il model
     * 
     * @param string $tabella
     * @param string $id
     * @param string $model
     */
    protected static function aggiornaIdDatabase ($tabella,$id){
        if($tabella!==null&&$id!==null){
            $maxId = Nazioni::max($id);
            $statement = "ALTER TABLE $tabella AUTO_INCREMENT = $maxId";
            $query = DB::statement($statement);
            if ($query !== null){
                return $query;
            }else{
                abort(404,'ATID_XXXX');
            }
        }else{
            abort(404,'ATID-BASE');
        }
    }

    /**
     * Prende l'id nel database ed il nome del Model e ritorna l'elemento se presente
     * 
     * @param string $id
     * @param string $model
     */
    protected static function trovaIdDatabase($id){
        $risorsa = Nazioni::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
    
    protected function creaCollection($nazioni)
    {
        $risorsa = null;
        $tipo = request("tipo");
        if ($tipo == "completo") {
            $risorsa = new NazioniCompletoCollection($nazioni);
        } else {
            $risorsa = new NazioniCollection($nazioni);
        }

        return $risorsa;
    }

    protected function creaRisorsa($categorie)
    {
        if ($categorie !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new NazioniCompletoResource($categorie);
            } else {
                $risorsa = new NazioniResource($categorie);
            }
    
            return $risorsa;

        }else{
            abort (404, 'CCF_0007');
        }
    }
}
