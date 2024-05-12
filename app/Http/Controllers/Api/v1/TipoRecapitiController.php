<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Requests\v1\TipoRecapitiStoreRequest;
use App\Http\Requests\v1\TipoRecapitiUpdateRequest;
use App\Http\Resources\v1\TipoRecapitiCollection;
use App\Http\Resources\v1\TipoRecapitiResource;
use App\Models\TipoRecapiti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class TipoRecapitiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ritorno=TipoRecapiti::all();
        if($ritorno!==null){
            return new TipoRecapitiCollection($ritorno);
        }else{
            abort(404,'TPC-I');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TipoRecapitiStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $config = TipoRecapiti::create($data);
                return new TipoRecapitiResource($config);
            } else {
                abort(403,'TRS_0001');
            }
        }  else {
            abort(404, 'TRS_0002');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idTipoRecapito)
    {
        $risorsa=$this->trovaIdDatabase($idTipoRecapito);
        if($risorsa!==null){
        return new TipoRecapitiResource($risorsa);
        }else{
            abort(404,'TRC-S');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TipoRecapitiUpdateRequest $request, $idTipoRecapito)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $risorsa = $this->trovaIdDatabase($idTipoRecapito);
                $risorsa->fill($data);
                $risorsa->save();
                return new TipoRecapitiResource($risorsa);
            } else {
                abort(403,'TRU_0001');
            }
        }  else {
            abort(404, 'TRU_0002');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idTipoRecapito)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('admin')) {
                $risorsa = $this->trovaIdDatabase($idTipoRecapito);
                $risorsa->deleteOrFail();
                $this->aggiornaIdDatabase('tipo_recapiti', 'idTipoRecapito');
                return response()->noContent();
            } else {
                abort(403,'TRD_0001');
            }
        }  else {
            abort(404, 'TRD_0002');
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
            $maxId = TipoRecapiti::max($id);
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
        $risorsa = TipoRecapiti::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
}
