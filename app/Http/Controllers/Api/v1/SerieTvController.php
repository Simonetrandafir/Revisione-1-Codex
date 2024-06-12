<?php

namespace App\Http\Controllers\Api\v1;


use App\Models\SerieTv;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\SerieTvStoreRequest;
use App\Http\Requests\v1\SerieTvUpdateRequest;
use App\Http\Resources\v1\SerieTvCollection;
use App\Http\Resources\v1\SerieTvCompletaCollection;
use App\Http\Resources\v1\SerieTvCompletaResource;
use App\Http\Resources\v1\SerieTvResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class SerieTvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serieTv=null;
        if (Gate::allows('leggere')) {
            $serieTv = SerieTv::where('visualizzato', 1)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $serieTv = SerieTv::all();
                }
                return $this->creaCollection($serieTv);
            } else {
                return new SerieTvCollection($serieTv);
            }
        }  else {
            abort(403, 'STV_0001');
        }
    }

    public function indexGenere($idGenere){
        $serieTv=null;
        if (Gate::allows('leggere')) {
            $serieTv = SerieTv::where('visualizzato', 1)->where('idGenere',$idGenere)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $serieTv = SerieTv::where('idGenere',$idGenere)->get();
                }
                return $this->creaCollection($serieTv);
            } else {
                return new SerieTvCollection($serieTv);
            }
        }  else {
            abort(403, 'STV_0000');
        }
    }

    public function indexRegista($regista){
        if (Gate::allows('leggere')) {
            $serieTv = SerieTv::where('visualizzato', 1)->where('regista',$regista)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $serieTv = SerieTv::where('regista',$regista)->get();
                }
                return $this->creaCollection($serieTv);
            } else {
                return new SerieTvCollection($serieTv);
            }
        }  else {
            abort(403, 'STV_0010');
        }
    }

    public function indexAnno($anno){
        $serieTv=null;
        if (Gate::allows('leggere')) {
            $serieTv = SerieTv::where('visualizzato', 1)->where('annoInizio',$anno)->get();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $serieTv = SerieTv::where('annoInizio',$anno)->get();
                }
                return $this->creaCollection($serieTv);
            } else {
                return new SerieTvCollection($serieTv);
            }
        }  else {
            abort(403, 'STV_0011');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SerieTvStoreRequest $request)
    {
        if (Gate::allows("creare")) {
            $data = $request->validated();
            $config = SerieTv::create($data);
            return new SerieTvCompletaResource($config);
        } else {
            abort(403,"STV_0003");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $idSerieTv)
    {
        if (Gate::allows('leggere')) {
            $serieTv = SerieTv::where('idSerieTv', $idSerieTv)
                ->where('visualizzato', 1)
                ->firstOrFail();
            if (Gate::allows('admin')) {
                if( request("tipo") ==='completo'){
                    $serieTv = $this->trovaIdDatabase($idSerieTv);
                }
                return $this->creaRisorsa($serieTv);
            } else{
                return new SerieTvResource($serieTv);
            }
        } else {
            abort(403,'STV_0002');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SerieTvUpdateRequest $request, $idSerieTv)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')){
                $data = $request->validated();
                $serieTv = $this->trovaIdDatabase($idSerieTv);
                $serieTv->fill($data);
                $serieTv->save();
                return new SerieTvCompletaResource($serieTv);
            }else {
                abort(403,'STV_0004');
            }
        } else {
            abort(404,'STV_0005');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idSerieTv)
    {
        if (Gate::allows('eliminare')) {
            $serieTv = $this->trovaIdDatabase($idSerieTv);
            $serieTv->deleteOrFail();
            $this->aggiornaIdDatabase('serie_tv', 'idSerieTv');
            return response()->noContent();
        } else {
            abort (403, 'STV_0006');
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
            $maxId = SerieTv::max($id);
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
        $risorsa = SerieTv::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
    protected function creaCollection($serieTv)
    {
        if ($serieTv !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new SerieTvCompletaCollection($serieTv);
            } else {
                $risorsa = new SerieTvCollection($serieTv);
            }
    
            return $risorsa;
        }else{
            abort (404, 'STVF_0006');
        }
    }
    protected function creaRisorsa($serieTv)
    {
        if ($serieTv !== null){
            $tipo = request("tipo");
            if ($tipo == "completo") {
                $risorsa = new SerieTvCompletaResource($serieTv);
            } else {
                $risorsa = new SerieTvResource($serieTv);
            }
    
            return $risorsa;

        }else{
            abort (404, 'STVF_0007');
        }
    }
}
