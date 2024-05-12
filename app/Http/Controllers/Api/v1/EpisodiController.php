<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\Episodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\EpisodiStoreRequest;
use App\Http\Requests\v1\EpisodiUpdateRequest;
use App\Http\Resources\v1\EpisodiCollection;
use App\Http\Resources\v1\EpisodiCompletaCollection;
use App\Http\Resources\v1\EpisodiCompletaResource;
use App\Http\Resources\v1\EpisodiResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EpisodiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $risorsa = Episodi::all();
                return $this->creaCollection($risorsa);
            } else {
                abort(403, 'EPCI_0002');
            }
        }else{
            abort(404, 'EPCI_0001');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(EpisodiStoreRequest $request)
    {
        if (Gate::allows("creare")) {
            $data = $request->validated();
            $config = Episodi::create($data);
            return new EpisodiCompletaResource($config);
        } else {
            abort(403,"EPC_0003");
        }
    }

    /**
     * Display the specified resource.
     */
    public function showEpisodio($idEpisodio)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $risorsa = $this->trovaIdDatabase($idEpisodio);
                return $this->creaRisorsa($risorsa);
            } else{
                $risorsa = Episodi::where('idEpisodio', $idEpisodio)
                ->where('visualizzato', 1)->firstOrFail();
                return new EpisodiResource($risorsa);
            }
        } else {
            abort(403,'EPCS_0002');
        }
    }
    public function episodiSerieTv($idSerieTv)
    {
        $stagione = request('stagione');
        $risorsa = null;
        if (Gate::allows('leggere')) {
            if ($stagione !== null){
                if (Gate::allows('admin')) {
                    $risorsa = Episodi::all()->where('idSerieTv',$idSerieTv)->where('stagione',$stagione);
                    $ritorno = $this->creaCollection($risorsa);
                } else {
                    $risorsa = Episodi::all()->where('idSerieTv',$idSerieTv)->where('stagione',$stagione)
                    ->where('visualizzato',1);
                    $ritorno = new EpisodiCollection($risorsa);
                }
            }else{
                if (Gate::allows('admin')) {
                    $risorsa = Episodi::all()->where('idSerieTv',$idSerieTv);
                    $ritorno = $this->creaCollection($risorsa);
                } else {
                    $risorsa = Episodi::all()->where('idSerieTv',$idSerieTv)->where('visualizzato',1);
                    $ritorno = new EpisodiCollection($risorsa);
                }
            }
            return $ritorno;
        }  else {
            abort(404, 'EPCS_00011');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EpisodiUpdateRequest $request, $idEpisodio)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')){
                $data = $request->validated();
                $risorsa = $this->trovaIdDatabase($idEpisodio);
                $risorsa->fill($data);
                $risorsa->save();
                return new EpisodiCompletaResource($risorsa);
            }else {
                abort(403,'EPCU_0004');
            }
        } else {
            abort(404,'EPCU_0005');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idEpisodio)
    {
        if (Gate::allows('eliminare')) {
            $episodio = $this->trovaIdDatabase($idEpisodio);
            $episodio->deleteOrFail();
            $this->aggiornaIdTabella('episodi','idEpisodio');
            return response()->noContent();
        } else {
            abort (403, 'EPC_0006');
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
            $maxId = Episodi::max($id);
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
        $risorsa = Episodi::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
    protected function creaCollection($risorsa)
    {
        if ($risorsa !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new EpisodiCompletaCollection($risorsa);
            } else {
                $risorsa = new EpisodiCollection($risorsa);
            }
    
            return $risorsa;
        }else{
            abort (404, 'EPCF_0006');
        }
    }
    protected function creaRisorsa($risorsa)
    {
        if ($risorsa !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new EpisodiCompletaResource($risorsa);
            } else {
                $risorsa = new EpisodiResource($risorsa);
            }
    
            return $risorsa;

        }else{
            abort (404, 'EPCF_0007');
        }
    }
}
