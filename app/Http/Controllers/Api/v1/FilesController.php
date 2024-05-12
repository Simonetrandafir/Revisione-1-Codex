<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Requests\v1\FilesStoreRequest;
use App\Http\Requests\v1\FilesUpdateRequest;
use App\Http\Resources\v1\FilesCollection;
use App\Http\Resources\v1\FilesResource;
use App\Models\Files;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $files = Files::all();
                return new FilesCollection($files);
            } else {
                abort(403, 'FC-I-0002');
            }
        }else{
            abort(404, 'FC-I-0001');
        }
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(FilesStoreRequest $request)
    // {
    //     if (Gate::allows('creare')) {
    //         if (Gate::allows('admin')) {
    //             $data = $request->validated();
    //             $files = Files::create($data);
    //             return new FilesResource($files);
    //         } else {
    //             abort(403, 'FC-ST-0002');
    //         }
    //     }else{
    //         abort(404, 'FC-ST-0001');
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show($idFile)
    {
        if (Gate::allows('leggere')) {
            $files = $this->trovaIdDatabase($idFile);
            return new FilesResource($files);
        }else{
            abort(404, 'FC-SH-0001');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilesUpdateRequest $request,$idFile)
    {
        if (Gate::allows('aggiornare')) {
            if (Gate::allows('admin')) {
                $data = $request->validated();
                $elemento = $this->trovaIdDatabase($idFile);
                $elemento->fill($data);
                $elemento->save();
                return new FilesResource($elemento);
            } else {
                abort(403, 'FC-U-0002');
            }
        }else{
            abort(404, 'FC-U-0001');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idFile)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('admin')) {
                $elemento = $this->trovaIdDatabase($idFile);
                $elemento->deleteOrFail();
                $this->aggiornaIdDatabase('files','idFile');
                return response()->noContent();
            } else {
                abort(403, 'FC-D-0002');
            }
        }else{
            abort(404, 'FC-D-0001');
        }
    }

    //? ------------------------- PROTECTED -------------------------------

/**
     * Aggiorna id della tabella ricevendo la tabelle, l'id della tabella e il model
     * 
     * @param string $tabella
     * @param string $id
     * @param string $model
     */
    protected static function aggiornaIdDatabase ($tabella,$id){
        if($tabella!==null&&$id!==null){
            $maxId = Files::max($id);
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
        $risorsa = Files::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }
}
