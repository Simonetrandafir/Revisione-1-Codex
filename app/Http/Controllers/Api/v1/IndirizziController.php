<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\v1\AccediController;
use App\Http\Requests\v1\IndirizziStoreRequest;
use App\Http\Requests\v1\IndirizziUpdateRequest;
use App\Http\Resources\v1\IndirizziCollection;
use App\Http\Resources\v1\IndirizziResource;
use App\Models\Contatti;
use App\Models\Indirizzi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class IndirizziController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $risorsa = Indirizzi::all();
                return new IndirizziCollection($risorsa);
            } else {
                abort(403, 'INC_0002');
            }
        } else {
            abort(404, 'INC_0001');
        }
    }

     /**
     * Aggiunge un nuovo indirizzo oltre quello fornito nella registrazione
     */
    public function aggiungiIndirizzo(IndirizziStoreRequest $request,$idContatto)
    {
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();

            if (Gate::allows('admin')){
                $indirizzo = Indirizzi::create($data);
                return new IndirizziResource($indirizzo);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKINC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $indirizzo = Indirizzi::create($data);
                    }else{
                        abort(403,'TKINC_0005');
                    }
                    return new IndirizziResource($indirizzo);
                }
            }
        } else {
            abort(404, 'CON-C_0001');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$idContatto)
    {
        if (Gate::allows('leggere')) {
            $data = $this->trovaIdDatabase($idContatto);
            if (Gate::allows('admin')) {
                return new IndirizziCollection($data);
            } else {
                //se la richiesta viene dall'utente prendo token
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKINC_0001');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        return new IndirizziCollection($data);
                    }else{
                        abort(403,'TKINC_0000');
                    }
                }
            }
        } else {
            abort(403, 'INC-S_0004');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndirizziUpdateRequest $request, $idContatto,$idIndirizzo)
    {
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();
            $indirizzo = $this->trovaIdDatabase($idIndirizzo);
            if (Gate::allows('admin')){
                $indirizzo->fill($data);
                $indirizzo->save();
                return new IndirizziResource($indirizzo);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKINC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $indirizzo->fill($data);
                        $indirizzo->save();
                    }else{
                        abort(403,'TKINC_0005');
                    }
                    return new IndirizziResource($indirizzo);
                }
            }
        } else {
            abort(403, 'INC-U_0007');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$idContatto,$idIndirizzo)
    {
        if (Gate::allows('aggiornare')) {
            $indirizzo = $this->trovaIdDatabase($idIndirizzo);
            if (Gate::allows('admin')){
                $indirizzo->deleteOrFail();
                $this->aggiornaIdDatabase('indirizzi', $idIndirizzo);
                return response()->noContent();
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKINC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $indirizzo->deleteOrFail();
                        $this->aggiornaIdDatabase('indirizzi', $idIndirizzo);
                        return response()->noContent();
                    }else{
                        abort(403,'TKINC_0005');
                    }
                }
            }
        }else{
            abort(404,'INC-D');
        }
    }

    // -----------------------------------------------------------------------------//
    //          *****   PROTECTED   *****           //
    /**
     * Aggiorna id della tabella ricevendo la tabelle, l'id della tabella e il model
     * 
     * @param string $tabella
     * @param string $id
     */
    protected static function aggiornaIdDatabase ($tabella,$id){
        if($tabella!==null&&$id!==null){
            $maxId = Indirizzi::max($id);
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
     */
    protected static function trovaIdDatabase($id){
        $risorsa = Indirizzi::findOrFail($id);
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
                abort(404, 'INCTK_0003');
            }
        }else{
            abort(404, 'INCTK_0002');
        }
    }
}
