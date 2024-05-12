<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Requests\v1\TraduzioniCustomsStoreRequest;
use App\Http\Requests\v1\TraduzioniCustomsUpdateRequest;
use App\Http\Resources\v1\TraduzioniCustomsResource;
use App\Models\TraduzioniCustom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class TraduzioniCustomController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(TraduzioniCustomsStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $config = TraduzioniCustom::create($data);
                return new TraduzioniCustomsResource($config);
            } else {
                abort(403,'TCCCS_0001');
            }
        }  else {
            abort(404, 'TCCCS_0002');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TraduzioniCustomsUpdateRequest $request,$idTraduzione)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $traduzione = $this->trovaIdDatabase($idTraduzione);
                $traduzione->fill($data);
                $traduzione->save();
                return new TraduzioniCustomsResource($traduzione);
            } else {
                abort(403,'TCCCU_0001');
            }
        }  else {
            abort(404, 'TCCCU_0002');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idTraduzione)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('admin')) {
                $traduzione = $this->trovaIdDatabase($idTraduzione);
                $traduzione->deleteOrFail();
                $this->aggiornaIdDatabase('traduzioni_customs','idTraduzione');
                return response()->noContent();
            } else {
                abort(403,'TCCCD_0001');
            }
        }  else {
            abort(404, 'TCCCD_0002');
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
            $maxId = TraduzioniCustom::max($id);
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
        $risorsa = TraduzioniCustom::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
}
