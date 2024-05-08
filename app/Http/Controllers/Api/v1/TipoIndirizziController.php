<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Models\TipoIndirizzi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\TipoIndirizziStoreRequest;
use App\Http\Requests\v1\TipoIndirizziUpdateRequest;
use App\Http\Resources\v1\TipoIndirizziCollection;
use App\Http\Resources\v1\TipoIndirizziCompletaCollection;
use App\Http\Resources\v1\TipoIndirizziCompletaResource;
use App\Http\Resources\v1\TipoIndirizziResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TipoIndirizziController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoIndirizzi = TipoIndirizzi::all();
        if($tipoIndirizzi!==null){
            $ritorno = $this->creaCollection($tipoIndirizzi);
            return $ritorno;
        }else{
            abort(404,'TICC-I');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipoIndirizziStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $tipoIndirizzi = TipoIndirizzi::create($data);
                return $this->creaRisorsa($tipoIndirizzi);
            } else {
                abort(403,'TICS_0001');
            }
        }  else {
            abort(404, 'TICS_0002');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($idTipoIndirizzo)
    {
        $tipoIndirizzo = $this->trovaIdDatabase($idTipoIndirizzo);
        if($tipoIndirizzo!==null){
        return $this->creaRisorsa($tipoIndirizzo);
        }else{
            abort(404,'TICC-S');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipoIndirizziUpdateRequest $request, $idTipoIndirizzo)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $tipoIndirizzi = $this->trovaIdDatabase($idTipoIndirizzo);
                $tipoIndirizzi->fill($data);
                $tipoIndirizzi->save();
                return $this->creaRisorsa($tipoIndirizzi);
            } else {
                abort(403,'TICU_0001');
            }
        }  else {
            abort(404, 'TICU_0002');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idTipoIndirizzo)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('admin')) {
                $tipoIndirizzi = $this->trovaIdDatabase($idTipoIndirizzo);
                $tipoIndirizzi->deleteOrFail();
                $this->aggiornaIdDatabase('tipo_indirizzi', $idTipoIndirizzo);
                return response()->noContent();
            } else {
                abort(403,'TICD_0001');
            }
        }  else {
            abort(404, 'TICD_0002');
        }
        
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
            $maxId = TipoIndirizzi::max($id);
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
        $risorsa = TipoIndirizzi::findOrFail($id);
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
            $risorsa = new TipoIndirizziCompletaCollection($nazioni);
        } else {
            $risorsa = new TipoIndirizziCollection($nazioni);
        }

        return $risorsa;
    }

    protected function creaRisorsa($categorie)
    {
        if ($categorie !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new TipoIndirizziCompletaResource($categorie);
            } else {
                $risorsa = new TipoIndirizziResource($categorie);
            }
    
            return $risorsa;

        }else{
            abort (404, 'CCF_0007');
        }
    }
}
