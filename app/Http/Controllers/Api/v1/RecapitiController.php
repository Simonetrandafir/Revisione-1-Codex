<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\AccediController;
use App\Http\Requests\v1\RecapitiStoreRequest;
use App\Http\Requests\v1\RecapitiUpdateRequest;
use App\Http\Resources\v1\RecapitiCollection;
use App\Http\Resources\v1\RecapitiResource;
use App\Models\Contatti;
use App\Models\Recapiti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class RecapitiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $risorsa = Recapiti::all();
                return new RecapitiCollection($risorsa);
            } else {
                abort(403, 'REC-I_0002');
            }
        } else {
            abort(404, 'REC-I_0001');
        }
    }

     /**
     * Aggiunge un nuovo recapito oltre quello fornito nella registrazione
     */
    public function aggiungiRecapito(RecapitiStoreRequest $request,$idContatto)
    {
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();
            if (Gate::allows('admin')){
                $recapito=Recapiti::create($data);
                return new RecapitiResource($recapito);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKREC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $recapito=Recapiti::create($data);
                    }else{
                        abort(403,'TKREC_0005');
                    }
                    return new RecapitiResource($recapito);
                }
            }
        } else {
            abort(404, 'REC-ADD_0001');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$idContatto,$idRecapito)
    {
        if (Gate::allows('leggere')) {
            $data = $this->trovaIdDatabase($idRecapito);
            if (Gate::allows('admin')) {
                return new RecapitiCollection($data);
            } else {
                //se la richiesta viene dall'utente prendo token
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKREC_0001');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        return new RecapitiCollection($data);
                    }else{
                        abort(403,'TKREC_0000');
                    }
                }
            }
        } else {
            abort(403, 'REC-S_0004');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecapitiUpdateRequest $request, $idContatto,$idRecapito)
    {
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();
            $recapito = $this->trovaIdDatabase($idRecapito);
            if (Gate::allows('admin')){
                $recapito->fill($data);
                $recapito->save();
                return new RecapitiResource($recapito);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKREC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $recapito->fill($data);
                        $recapito->save();
                    }else{
                        abort(403,'TKREC_0005');
                    }
                    return new RecapitiResource($recapito);
                }
            }
        } else {
            abort(403, 'REC-U_0007');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$idContatto,$idRecapito)
    {
        if (Gate::allows('aggiornare')) {
            $recapito = $this->trovaIdDatabase($idRecapito);
            if (Gate::allows('admin')){
                $recapito->deleteOrFail();
                $this->aggiornaIdDatabase('recapiti', $idRecapito);
                return response()->noContent();
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKREC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $recapito->deleteOrFail();
                        $this->aggiornaIdDatabase('recapiti', $idRecapito);
                        return response()->noContent();
                    }else{
                        abort(403,'TKREC_0005');
                    }
                }
            }
        }else{
            abort(404,'REC-D');
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
            $maxId = Recapiti::max($id);
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
        $risorsa = Recapiti::findOrFail($id);
        if ($risorsa !== null){
            return $risorsa;
        }else{
            abort(404,'FIDAH-XXXX');
        }
    }

    protected function controlloId ($idContatto,$token){
        $payload = AccediController::verificaToken($token);
        if($payload !== null){
            $contattoDB = Contatti::where('idContatto', $payload->data->idContatto)->firstOrFail();
            if ($contattoDB->idContatto == $idContatto){
                return true;
            }else{
                abort(404, 'RECTK_0003');
            }
        }else{
            abort(404, 'RECTK_0002');
        }
    }
}
