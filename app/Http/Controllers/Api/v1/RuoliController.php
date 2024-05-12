<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\v1\RuoliStoreRequest;
use App\Http\Requests\v1\RuoliUpdateRequest;
use App\Http\Resources\v1\RuoliResource;
use App\Models\Ruoli;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\RuoliCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RuoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

                $ruoli = Ruoli::all();
                if($ruoli){
                    return new RuoliCollection($ruoli);

                }else{
                    abort(404,'RC-I');
                }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RuoliStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('admin')) {
                $data=$request->validated();
                $ruolo = Ruoli::create($data);
                return new RuoliResource($ruolo);
            } else {
                abort(403,'RCS_0001');
            }
        }  else {
            abort(404, 'RCS_0002');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idRuolo)
    {

        $ruolo = Ruoli::find($idRuolo);
        if (!$ruolo) {
            // Gestisci il caso in cui lo stato non esista
            abort(404, 'RC_0003');
        }else{
            return new RuoliResource($ruolo);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RuoliUpdateRequest $request, $idRuolo)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')) {
                $data= Ruoli::find($idRuolo);
                $newData=$request->validated();
                $data->fill($newData);
                $data->save();
                return new RuoliResource($data);
            } else {
                abort(404,'RCU_0001');
            }
        }  else {
            abort(404, 'RCU_0002');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idRuolo)
    {
        if (Gate::allows('distruggere')) {
            if (Gate::allows('admin')) {
                $ruolo= Ruoli::find($idRuolo);
                $ruolo->deleteOrFail();
                $this->aggiornaIdDatabase('ruoli','idRuolo');
                return response()->noContent();
            } else {
                abort(404,'RCD_0001');
            }
        }  else {
            abort(404, 'RCD_0002');
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
            $maxId = Ruoli::max($id);
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
}
