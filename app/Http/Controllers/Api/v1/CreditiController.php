<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\v1\CreditiCollection;
use App\Models\Contatti;
use App\Models\Crediti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreditiUpdateRequest;
use App\Http\Resources\v1\CreditiResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class CreditiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $risorsa = Crediti::all();
                return new CreditiCollection($risorsa);
            } else {
                abort(403, 'CRC-I-0');
            }
        } else {
            abort(404, 'CRC-I-1');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$idContatto)
    {
        
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $credito = $this->trovaIdDatabase($idContatto);
                return new CreditiResource($credito);
            } else {
                //se la richiesta viene dall'utente prendo token
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TK-CRC_0008');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $credito = $this->trovaIdDatabase($idContatto);
                        return new CreditiResource($credito);
                    }else{
                        abort(403,'TK-CRC_0009');
                    }
                }
            }
        } else {
            abort(403, 'CRC-S');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreditiUpdateRequest $request, $idContatto)
    {
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();
            $credito = Crediti::all()->where('idContatto',$idContatto)->firstOrFail();
            if (Gate::allows('admin')){
                $valore=$credito->credito;
                $newValore=$data['credito'];
                $newCredito=$valore+$newValore;
                $credito->credito = $newCredito;
                $credito->save();
                return new CreditiResource($credito);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TK-CRC_0006');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $valore=$credito->credito;
                        $newValore=$data['credito'];
                        $newCredito=$valore+$newValore;
                        $credito->credito = $newCredito;
                        $credito->save();
                    }else{
                        abort(403,'TK-CRC_0007');
                    }
                    return new CreditiResource($credito);
                }
            }
        } else {
            abort(403, 'CRC-U');
        }
    }

    //------------------- PROTECTED ----------------------

    /**
     * Prende l'id nel database ed il nome del Model e ritorna l'elemento se presente
     * 
     * @param string $id
     * @param string $model
     */
    protected static function trovaIdDatabase($id){
        $risorsa = Crediti::all()->where('idContatto',$id)->firstOrFail();
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
                abort(404, 'TK-CRC_0003');
            }
        }else{
            abort(404, 'TK-CRC_0002');
        }
    }
}
