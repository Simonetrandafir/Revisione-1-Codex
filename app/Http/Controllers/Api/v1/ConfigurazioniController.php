<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\Configurazioni;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ConfigurazioniStoreRequest;
use App\Http\Requests\v1\ConfigurazioniUpdateRequest;
use App\Http\Resources\v1\ConfigurazioniCollection;
use App\Http\Resources\v1\ConfigurazioniResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class ConfigurazioniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Configurazioni::all();
        if($data){
            return new ConfigurazioniCollection($data);
        }else{
            abort(404,'CONF-C-I');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConfigurazioniStoreRequest $request)
    {
        if (Gate::allows("creare")) {
            $data = $request->validated();
            $config = Configurazioni::create($data);
            return new ConfigurazioniResource($config);
        } else {
            abort(403,"CCC_0002");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idConfigurazione)
    {
        $data=$this->trovaIdDatabase($idConfigurazione);
        if($data){
            return new ConfigurazioniResource($data);
        }else{
            abort(404,"CONF-C-S");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConfigurazioniUpdateRequest $request, $idConfigurazione)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')){
                $data = $request->validated();
                $configurazioni = $this->trovaIdDatabase($idConfigurazione);
                $configurazioni->fill($data);
                $configurazioni->save();
                return new ConfigurazioniResource($configurazioni);
            }else {
                abort(403,'CCC_0005');
            }
        } else {
            abort(403,'CCC_0006');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idConfigurazione)
    {
        if (Gate::allows('eliminare')) {
            $configurazione = $this->trovaIdDatabase($idConfigurazione);
            $configurazione->deleteOrFail();
            $this->aggiornaIdDatabase('configurazioni','idConfigurazioni');
            return response()->noContent();
        } else {
            abort (403, 'CCC_0007');
        }
    }
    // !-----------------------------------------------------------------------------//
    //!          *****   PROTECTED   *****           //
    /**
     * Aggiorna id della tabella ricevendo la tabelle, l'id della tabella e il model
     * 
     * @param string $tabella
     * @param string $id
     * @param string $model
     */
    protected static function aggiornaIdDatabase ($tabella,$id){
        if($tabella!==null&&$id!==null){
            $maxId = Configurazioni::max($id);
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
        $risorsa = Configurazioni::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
}
