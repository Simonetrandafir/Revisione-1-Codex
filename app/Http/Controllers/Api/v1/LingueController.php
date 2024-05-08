<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Requests\v1\LingueStoreRequest;
use App\Http\Requests\v1\LingueUpdateRequest;
use App\Http\Resources\v1\LingueCollection;
use App\Http\Resources\v1\LingueResource;
use App\Models\Lingue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class LingueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lingue = Lingue::all();
        if($lingue!==null){
            $ritorno = new LingueCollection($lingue);
            return $ritorno;
        }else{
            abort(404, "L-I");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LingueStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $lingua = Lingue::create($data);
                return new LingueResource($lingua);
            } else {
                abort(403,'LCS_0001');
            }
        }  else {
            abort(404, 'LCS_0002');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idLingua)
    {
        $lingua = $this->trovaIdDatabase($idLingua);
        if($lingua!==null){
            return new LingueResource($lingua);
        }else{
            abort(404, "L-S");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LingueUpdateRequest $request, $idLingua)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $lingua = $this->trovaIdDatabase($idLingua);
                $lingua->fill($data);
                $lingua->save();
                return new LingueResource($lingua);
            } else {
                abort(403,'LCU_0001');
            }
        }  else {
            abort(404, 'LCU_0002');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idLingua)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('admin')) {
                $lingua = $this->trovaIdDatabase($idLingua);
                $lingua->deleteOrFail();
                $this->aggiornaIdDatabase('lingue', $idLingua);
                return response()->noContent();
            } else {
                abort(403,'LCD_0001');
            }
        }  else {
            abort(404, 'LCD_0002');
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
            $maxId = Lingue::max($id);
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
        $risorsa = Lingue::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
}
