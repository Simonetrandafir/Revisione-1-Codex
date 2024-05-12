<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\AccediController;
use App\Http\Requests\v1\PasswordStoreRequest;
use App\Http\Requests\v1\PasswordUpdateRequest;
use App\Http\Resources\v1\PasswordCollection;
use App\Http\Resources\v1\PasswordResource;
use App\Models\Contatti;
use App\Models\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('admin')) {
                $risorsa = Password::all();
                return new PasswordCollection($risorsa);
            } else {
                abort(403, 'PSC_0002');
            }
        } else {
            abort(404, 'PSC_0001');
        }
    }

     /**
     * Aggiunge un nuovo password oltre quello fornito nella registrazione
     */
    public function aggiungiPassword(PasswordStoreRequest $request,$idContatto)
    {
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();

            if (Gate::allows('admin')){
                $password = Password::create($data);
                return new PasswordResource($password);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKPSC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $password = Password::create($data);
                    }else{
                        abort(403,'TKPSC_0005');
                    }
                    return new PasswordResource($password);
                }
            }
        } else {
            abort(404, 'PSC-ADD_0001');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PasswordUpdateRequest $request,$idContatto)
    {
        if (Gate::allows('aggiornare')) {
            $data = $request->validated();
            $password = $this->trovaIdDatabase($idContatto);
            if (Gate::allows('admin')){
                $password->fill($data);
                $password->save();
                return new PasswordResource($password);
            }else{
                $token = $request->bearerToken();
                if (!$token) { // Verifica se il token è presente nella richiesta
                    abort(403, 'TKPC_0004');
                }else{
                    //controllo che l'idContatto corrisponda all'id nel token
                    $controllo = $this->controlloId($idContatto,$token);
                    if ($controllo === true){
                        $password->fill($data);
                        $password->save();
                    }else{
                        abort(403,'TKPC_0005');
                    }
                    return new PasswordResource($password);
                }
            }
        } else {
            abort(403, 'PSC-U_0007');
        }
    }

    // -----------------------------------------------------------------------------//
    //          *****   PROTECTED   *****           //

    /**
     * Prende l'id nel database ed il nome del Model e ritorna l'ultimo elemento se presente
     * 
     * @param string $id
     * @param string $model
     */
    protected static function trovaIdDatabase($id){
        $risorsa = Password::all()->where('idContatto',$id)->last();
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
                abort(404, 'TKM_0003');
            }
        }else{
            abort(404, 'TKM_0002');
        }
    }
}
