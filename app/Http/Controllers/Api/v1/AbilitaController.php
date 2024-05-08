<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\v1\AbilitaStoreRequest;
use App\Http\Requests\v1\AbilitaUpdateRequest;
use App\Http\Resources\v1\AbilitaCollection;
use App\Models\Abilita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AbilitaResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AbilitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Abilita::all();
        if($data!==null){
        return new AbilitaCollection($data);
        }else{
            abort(404,"ABC-I");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AbilitaStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('admin')) {
                $data=$request->validated();
                $abilita = Abilita::create($data);
                return new AbilitaResource($abilita);
            } else {
                abort(403,'ABCS_0001');
            }
        }  else {
            abort(404, 'ABCS_0002');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idAbilita)
    {

        $abilita = Abilita::find($idAbilita);
        if (!$abilita) {
            // Gestisci il caso in cui lo abilita non esista
            abort(404, 'ABCSH_0003 ');
        }else{
            return new AbilitaResource($abilita);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AbilitaUpdateRequest $request, $idAbilita)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')) {
                $data= Abilita::find($idAbilita);
                $newData=$request->validated();
                $data->fill($newData);
                $data->save();
                return new AbilitaResource($data);
            } else {
                abort(404,'ABCU_0001');
            }
        }  else {
            abort(404, 'ABCU_0002');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idAbilita)
    {
        if (Gate::allows('distruggere')) {
            if (Gate::allows('admin')) {
                $abilita= Abilita::find($idAbilita);
                $abilita->deleteOrFail();
                $this->aggiornaIdDatabase('abilita',$idAbilita);
                return response()->noContent();
            } else {
                abort(404,'ABCD_0001');
            }
        }  else {
            abort(404, 'ABCD_0002');
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
            $maxId = Abilita::max($id);
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
